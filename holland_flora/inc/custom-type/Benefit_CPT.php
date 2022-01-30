<?php

if (!class_exists('Benefit_CPT')) {
    class Benefit_CPT
    {
        use Singleton;

        const NAME = 'benefit';

        public static function register()
        {
            $type = self::get_instance();
            add_theme_support('post-thumbnails');
            add_action('init', [$type, self::NAME . '_post_type']);
        }

        public function benefit_post_type()
        {
            register_post_type(self::NAME, array(
                'labels' => array(
                    'name' => 'Выгоды',
                    'singular_name' => 'Выгода',
                    'add_new' => 'Добавить новую',
                    'add_new_item' => 'Добавить новую выгоду',
                    'edit_item' => 'Редактировать выгоду',
                    'new_item' => 'Новая выгода',
                    'view_item' => 'Посмотреть выгоду',
                    'search_items' => 'Найти выгоду',
                    'not_found' => 'Выгод не найдено',
                    'not_found_in_trash' => 'В корзине выгод не найдено',
                    'parent_item_colon' => '',
                    'menu_name' => 'Выгоды'

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
                'menu_icon' => 'dashicons-smiley',
                'supports' => array('title', 'excerpt', 'thumbnail')
            ));
        }
    }
}