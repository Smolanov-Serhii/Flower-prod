<?php

if (!class_exists('Remove_from_Cart')) {
    class Remove_from_Cart
    {
        use Singleton;

        const ACTION = 'remove_from_cart';

        public static function register()
        {
            $handler = self::get_instance();

            add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);
            add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);
        }

        public function handle()
        {
            try {
                extract($_POST);
                if (!empty($p) && isset($_SESSION) && !empty($_SESSION['cart'])) {
                    unset($_SESSION['cart'][$p]);
                }

                wp_send_json([
                    'success' => true
                ]);

            } catch (Exception $e) {
                wp_send_json([
                    'success' => false
                ]);
            }
        }
    }
}