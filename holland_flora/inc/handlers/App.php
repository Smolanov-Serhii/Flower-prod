<?php

if (!class_exists('App')) {
    class App
    {
        use Singleton;

        const ACTION = 'apps';
        const EMAIL = 'support@hollandflora.com.ua';
        const TYPES = array('call' => '_call', 'chat' => '_chat');

        public static function register()
        {
            $handler = self::get_instance();

            add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);
            add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);
        }

        public function handle()
        {
            try {
                $id = !empty($_POST['id']) ? $_POST['id'] : null;
                unset($_POST['id'], $_POST['action']);

                if (method_exists(__CLASS__, self::TYPES[$id])) {
                    $method = self::TYPES[$id];
                    $res = $this->$method($_POST);

                    wp_send_json($res);
                    exit;
                }

            } catch (Exception $e) {
                exit;
            }
        }

        private function _call($data)
        {
            extract($data);

            if (!empty($name) && !empty($tel)) {

                $to = self::EMAIL;
                $subject = 'Holland Flora - "Перезвоните мне"';

//                $headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
//                $headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
//                $headers .= "CC: susan@example.com\r\n";
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $message = $this->_mailTemplate($data, $subject);

                $send = mail($to, $subject, $message, $headers);
                return array(
                    'success' => $send,
                    'popup' => 'formPopup',
                    'title' => $send ? pll__('Спасибо') . '!' : pll__('Ошибка') . '!',
                    'msg' => $send ?
                        array('title' => pll__('Спасибо за заявку.'), 'desc' => pll__('Мы свяжемся с вами в ближайшее время')) :
                        array('title' => pll__('Произошла какая-то ошибка.'), 'desc' => pll__('Попробуйте снова через несколько минут'))
                );
            } else {
                return array(
                    'success' => 0,
                    'popup' => 'formPopup',
                    'msg' => array('title' => pll__('Произошла какая-то ошибка.'), 'desc' => pll__('Попробуйте снова через несколько минут'))
                );
            }
        }

        private function _chat($data)
        {
            extract($data);
            if (!empty($email) && !empty($msg) && !empty($name)) {
                $to = self::EMAIL;
                $subject = 'Holland Flora - "Чат"';

                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $message = $this->_mailTemplate($data, $subject);

                $send = mail($to, $subject, $message, $headers);
                return array(
                    'success' => $send,
                    'popup' => 'formPopup',
                    'title' => $send ? pll__('Спасибо') . '!' : pll__('Ошибка') . '!',
                    'msg' => $send ?
                        array('title' => pll__('Спасибо за заявку.'), 'desc' => pll__('Мы свяжемся с вами в ближайшее время')) :
                        array('title' => pll__('Произошла какая-то ошибка.'), 'desc' => pll__('Попробуйте снова через несколько минут'))
                );
            } else {
                return array(
                    'success' => 0,
                    'popup' => 'formPopup',
                    'msg' => array('title' => pll__('Произошла какая-то ошибка.'), 'desc' => pll__('Попробуйте снова через несколько минут'))
                );
            }
        }

        private function _mailTemplate($data, $title)
        {
            $th = '';
            $td = '';
            foreach ($data as $key => $value) {
                $th .= "<th>{$key}</th>";
                $td .= "<td>{$value}</td>";
            }
            $table = "<table><tr>{$th}</tr><tr>{$td}</tr></table>";
            return "<html>
                        <head><title>{$title}</title></head>
                        <body>{$table}</body>
                    </html>";
        }
    }
}