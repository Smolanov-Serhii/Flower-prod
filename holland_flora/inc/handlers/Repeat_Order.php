<?php

if (!class_exists('Repeat_Order')) {
    class Repeat_Order
    {
        use Singleton;
        const ACTION = 'repeat_order';

        public static function register()
        {
            $handler = self::get_instance();

            add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);
            add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);
        }

        public function handle()
        {
            extract($_POST);

            if (!empty($p)) {
                $cart = get_post_meta($p, 'cart', true);
                !empty($cart) && isset($_SESSION) && $_SESSION['cart'] = $cart;

                wp_send_json(['success' => 'true']);
            }

            wp_send_json([
                'success' => false
            ]);

        }
    }
}