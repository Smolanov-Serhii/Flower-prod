<?php

if (!class_exists('ChangeItemsCount')) {
    class ChangeItemsCount
    {
        use Singleton;

        const ACTION = 'change_items_count';

        public static function register()
        {
            $handler = self::get_instance();

            add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);
            add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);
        }

        public function handle()
        {
            extract($_POST);

            if (isset($_SESSION) && !empty($_SESSION['cart']) && !empty($p) && !empty($c)) {
                if (!empty($_SESSION['cart'][$p])) {
                    $_SESSION['cart'][$p] = $c;
                }
            }
        }

    }
}