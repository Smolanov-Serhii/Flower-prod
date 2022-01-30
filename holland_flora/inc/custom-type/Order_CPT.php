<?php

if (!class_exists('Order_CPT')) {
    class Order_CPT
    {
        use Singleton;

        const NAME = 'order';

        public static function register()
        {
            $type = self::get_instance();
//            add_theme_support('post-thumbnails');
            add_action('init', [$type, self::NAME . '_post_type']);
        }

        public function order_post_type()
        {
            register_post_type(self::NAME, array(
                'labels' => array(
                    'name' => 'Заказы',
                    'singular_name' => 'Заказ',
                    'add_new' => 'Добавить новый',
                    'add_new_item' => 'Добавить новый заказ',
                    'edit_item' => 'Редактировать заказ',
                    'new_item' => 'Новый заказ',
                    'view_item' => 'Посмотреть заказ',
                    'search_items' => 'Найти заказ',
                    'not_found' => 'Заказов не найдено',
                    'not_found_in_trash' => 'В корзине заказ не найдено',
                    'parent_item_colon' => '',
                    'menu_name' => 'Заказы'

                ),
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => false,
                'rewrite' => false,
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'menu_position' => null,
                'menu_icon' => 'dashicons-money-alt',
                'supports' => array('title', 'editor', 'author')
            ));
        }
    }
}