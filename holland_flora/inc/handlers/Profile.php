<?php

if (!class_exists('Profile')) {
    class Profile
    {
        use Singleton;

        const ACTION = 'profile_action';

        const VALIDATION_RULES = [
            'full_name' => ['full_name' => 'required|min:5|max:20'],
            'tel' => ['tel' => 'required|tel'],
            'email' => ['email' => 'required|email|unique'],
            'company' => ['company' => 'required|min:0'],
            'business' => ['business' => 'required'],
            'country' => ['country' => 'required'],
            'address' => ['address' => 'required'],
            'password' => ['password' => 'required|min:6'],
        ];

        public static function register()
        {
            $handler = self::get_instance();

            add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);
            // add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);
        }

        public function handle()
        {
            $data = $_POST;

            if (empty($data['key']) || empty($data[$data['key']])) {
                wp_send_json([
                    'success' => true,
                    'msg' => 'Ошибка! Побробуйте снова через пару минут.'
                ]);
            }

            $errors = Validator::validate($data, self::VALIDATION_RULES[$data['key']]);

            if (!empty($errors)) {
                wp_send_json([
                    'success' => false,
                    'msg' => $errors[0]
                ]);
            }

            $user = wp_get_current_user();
            if (empty($user->ID)) {
                wp_send_json([
                    'success' => true,
                    'msg' => 'Ошибка! Побробуйте снова через пару минут.'
                ]);
            }

            if ($data['key'] === 'email') {
                $args = array(
                    'ID' => $user->ID,
                    'user_email' => esc_attr($data[$data['key']])
                );
                wp_update_user($args);
            } else {
                $user_info = get_user_meta($user->ID, Auth::USER_META_KEY, true);
                $old = $user_info;
                $user_info[$data['key']] = $data[$data['key']];

                update_user_meta($user->ID, Auth::USER_META_KEY, $user_info, $old);
            }

            wp_send_json([
                'success' => true,
                'msg' => 'Данные успешно обновлены',
                'key' => $data['key'],
                'value' => $data[$data['key']]
            ]);
        }
    }
}
