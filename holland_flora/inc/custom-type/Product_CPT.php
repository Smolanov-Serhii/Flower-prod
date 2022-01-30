<?php

if (!class_exists('Product_CPT')) {
    class Product_CPT
    {
        use Singleton;

        const NAME = 'product';

        public static function register()
        {
            $type = self::get_instance();
            add_theme_support('post-thumbnails');
            add_action('init', [$type, self::NAME . '_post_type']);
            add_action('init', [$type, self::NAME . '_category_taxonomy']);
        }

        public function product_post_type()
        {
            register_post_type(self::NAME, array(
                'labels' => array(
                    'name' => 'Продукты',
                    'singular_name' => 'Продукт',
                    'add_new' => 'Добавить новый',
                    'add_new_item' => 'Добавить новый продукт',
                    'edit_item' => 'Редактировать продукт',
                    'new_item' => 'Новый продукт',
                    'view_item' => 'Посмотреть продукт',
                    'search_items' => 'Найти продукт',
                    'not_found' => 'Продуктов не найдено',
                    'not_found_in_trash' => 'В корзине продуктов не найдено',
                    'parent_item_colon' => '',
                    'menu_name' => 'Продукты'

                ),
                'taxonomies' => array('recordings'),
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => false,
                'rewrite' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'menu_icon' => 'dashicons-products',
                'supports' => array('title', 'excerpt', 'thumbnail')
            ));
        }

        public function product_category_taxonomy()
        {
            register_taxonomy('type', ['product'], [
                'label' => '',
                'labels' => [
                    'name' => 'Категория',
                    'singular_name' => 'Категория',
                    'search_items' => 'Найти категорию',
                    'all_items' => 'Все категории',
                    'view_item ' => 'Посмотреть категорию',
                    'parent_item' => 'Родительская категория',
                    'parent_item_colon' => 'Родительская категория:',
                    'edit_item' => 'Редактировать категорию',
                    'update_item' => 'Обновить категорию',
                    'add_new_item' => 'Добавить новую категорию',
                    'new_item_name' => 'Имя новой категории',
                    'menu_name' => 'Категории',
                ],
                'description' => '', // описание таксономии
                'public' => true,
                // 'publicly_queryable'    => null, // равен аргументу public
                // 'show_in_nav_menus'     => true, // равен аргументу public
                // 'show_ui'               => true, // равен аргументу public
                // 'show_in_menu'          => true, // равен аргументу show_ui
                // 'show_tagcloud'         => true, // равен аргументу show_ui
                // 'show_in_quick_edit'    => null, // равен аргументу show_ui
                'hierarchical' => true,

                'rewrite' => true,
                //'query_var'             => $taxonomy, // название параметра запроса
                'capabilities' => array(),
                'meta_box_cb' => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
                'show_admin_column' => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
                'show_in_rest' => null, // добавить в REST API
                'rest_base' => null, // $taxonomy
                // '_builtin'              => false,
                //'update_count_callback' => '_update_post_term_count',
            ]);
        }
    }
}