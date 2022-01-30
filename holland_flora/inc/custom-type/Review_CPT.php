<?php

if (!class_exists('Review_CPT')) {
    class Review_CPT
    {
        use Singleton;

        const NAME = 'review';

        public static function register()
        {
            $type = self::get_instance();
            add_action('init', [$type, self::NAME . '_post_type']);
        }

        public function review_post_type()
        {
            register_post_type(self::NAME, array(
                'labels' => array(
                    'name' => 'Отзывы',
                    'singular_name' => 'Отзыв',
                    'add_new' => 'Добавить новый',
                    'add_new_item' => 'Добавить новый отзыв',
                    'edit_item' => 'Редактировать отзыв',
                    'new_item' => 'Новый отзыв',
                    'view_item' => 'Посмотреть отзыв',
                    'search_items' => 'Найти отзыв',
                    'not_found' => 'Отзывов не найдено',
                    'not_found_in_trash' => 'В корзине отзывов не найдено',
                    'parent_item_colon' => '',
                    'menu_name' => 'Отзывы'

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
                'menu_icon' => 'dashicons-thumbs-up',
                'supports' => array('title', 'editor', 'thumbnail')
            ));
        }
    }
}