<?php

if (!class_exists('Auth')) {
    class Auth
    {
        use Singleton;

        const ACTION = 'auth';

        const TYPES = ['register' => '_register', 'login' => '_login', 'logout' => '_logout', 'forgot_pass' => '_forgot_pass', 'restore_pass' => '_restore_pass'];

        const VALIDATION_RULES = [
            'login' => [
                'email' => 'required',
                'password' => 'required'
            ],
            'register' => [
                'login' => 'required|min:3|max:30|login',
                'full_name' => 'required|full_name',
                'tel' => 'required|tel',
                'email' => 'required|email|unique',
                'company' => 'required|min:0',
                'business' => 'required',
                'country' => 'required',
//                'address' => 'required',
                'password' => 'required|min:6',
            ],
            'forgot_pass' => ['email' => 'required|exist'],
            'restore_pass' => ['password' => 'required|min:6']
        ];

        const USER_META = ['full_name', 'tel', 'company', 'business', 'country', 'address'];
        const USER_META_KEY = 'info';

        public static function register()
        {
            $handler = self::get_instance();

            add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);
            add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);
        }

        public function handle()
        {
            try {
                $data = $_POST;
                $method = $data['type'] ?? '';
                if (method_exists(__CLASS__, self::TYPES[$method])) {
                    $method = self::TYPES[$method];
                    $res = $this->$method($data);

                    if (!empty($res['errors']))
                        wp_send_json([
                            'type' => 'auth',
                            'success' => false,
                            'errors' => $res['errors']
                        ]);


                    $route = !empty($_SESSION['redirect']) ? $_SESSION['redirect'] : site_url('/');

                    unset($_SESSION['redirect']);

                    wp_send_json([
                        'type' => 'auth',
                        'success' => true,
                        'route' => $route,
                        'id' => $data['type']
                    ]);

                    die;
                }
            } catch (Exception $e) {
                wp_send_json([
                    'type' => 'auth',
                    'success' => false,
                    'errors' => [$e->getMessage()]
                ]);
            }
        }


        private function _register($data)
        {
            $errors = Validator::validate($data, self::VALIDATION_RULES['register']);
            if (!empty($errors))
                return ['errors' => $errors];
            else {
                $user_id = wp_create_user($data['login'], $data['password'], $data['email']);

                if (is_wp_error($user_id)) {
                    return ['errors' => [pll__('Логин должен состоять из латинских букв')]];
                    return ['errors' => [$user_id->get_error_message()]];
                } else {

                    $user_info = [];
                    foreach ($data as $key => $value) {
                        if (in_array($key, self::USER_META)) {
                            $user_info[$key] = trim($value);
                        }
                    }

                    if (!empty($user_info)) {
                        add_user_meta($user_id, self::USER_META_KEY, $user_info, false);
                    }

                    $user = wp_signon([
                        'user_login' => $data['login'],
                        'user_password' => $data['password'],
                        'remember' => false,
                    ]);

                    if (is_wp_error($user)) {
                        return ['errors' => [pll__('Логин должен состоять из латинских букв')]];
                        return ['errors' => [$user->get_error_message()]];
                    }

                    return true;
                }
            }
        }

        private function _login($data)
        {
            $errors = Validator::validate($data, self::VALIDATION_RULES['login']);

            $remember = isset($data['remember']) && ($data['remember'] == 'on');

            if (!empty($errors))
                return ['errors' => $errors];
            else {
                $user = wp_signon([
                    'user_login' => $data['email'],
                    'user_password' => $data['password'],
                    'remember' => $remember,
                ]);

                if (is_wp_error($user)) {
                    return ['errors' => [$user->get_error_message()]];
                }

                return true;
            }
        }

        private function _forgot_pass($data)
        {
            $errors = Validator::validate($data, self::VALIDATION_RULES['forgot_pass']);
            if (!empty($errors))
                return ['errors' => $errors];
            else {
                $user = get_user_by('email', $data['email']);

                if (is_wp_error($user)) {
                    return ['errors' => [$user->get_error_message()]];
                } else {
                    $key = base64_encode($data['email']);
                    update_user_meta($user->ID, '_token', $key, false);

                    $to = $data['email'];
                    $subject = 'Holland Flora - "Восстановление пароля"';

                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                    $link = site_url("forgot-pass/?key={$key}");

                    $message = "<p>Для восстановления пароля перейдите по ссылке:</p><a href='{$link}'>Восстановить</a>";

                    return mail($to, $subject, $message, $headers);
                }
            }
        }

        private function _restore_pass($data)
        {
            $errors = Validator::validate($data, self::VALIDATION_RULES['restore_pass']);

            if (!empty($errors))
                return ['errors' => $errors];
            else {

                if ($data['password'] !== $data['confirm_password']) {
                    return ['errors' => ['Пароли не совпадают.']];
                }

                $user = get_user_by('email', $data['email']);

                delete_user_meta($user->ID, '_token');

                wp_set_password($data['password'], $user->ID);
                return true;
            }
        }

        private function _logout($data)
        {
            wp_logout();
            wp_safe_redirect('/');
            die;
        }
    }
}
