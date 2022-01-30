<?php

if (!class_exists('Add_to_Cart')) {
    class Add_to_Cart
    {
        use Singleton;

        const ACTION = 'add_to_cart';

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

                if (!empty($product_id) && !empty($count) && isset($_SESSION)) {
                    $cart = !empty($_SESSION['cart']) ? $_SESSION['cart'] : array();
                    $old_count = !empty($cart[$product_id]) ? $cart[$product_id] : 0;
                    $cart[$product_id] = $count + $old_count;
                    $_SESSION['cart'] = $cart;

                    wp_send_json([
                        'success' => true,
                        'msg' => 'Товар успешно добавлен в корзину.',
                        'id' => 'add_to_cart'
                    ]);
                }
            } catch (Exception $e) {
                wp_send_json([
                    'success' => false,
                    'msg' => pll__('При добавлени товара в корзину произошла ошибка.'),
                    'id' => 'add_to_cart'
                ]);
            }
        }
    }
}
