<?php
if (!class_exists('Helper')) {
    class Helper
    {
        const STATUS_PUBLISHED = 'publish';
        const DEFAULT_NUMBERPOSTS = 6;
        const PRODUCTS_NUMBERPOSTS = 24;
        const PRODUCT_CAT = 'type';
        const PRODUCT = 'product';
        const TAX = 'type';

        const PER_PAGE = [24, 48, 72, 96];
        const ORDER_BY = [
            'В начале дорогие' => ['orderby' => 'meta_value_num', 'meta_key' => 'product-price', 'order' => 'DESC'],
            'В начале дешевые' => ['orderby' => 'meta_value_num', 'meta_key' => 'product-price', 'order' => 'ASC'],
            'По алфавиту' => ['orderby' => 'title', 'order' => 'ASC']
        ];

        /**
         * Get Multiple Theme Options
         * @param array $option_keys Theme Option Keys
         * @return array Theme Options
         */
        public static function get_options($option_keys)
        {
            $res = [];
            foreach ($option_keys as $value) {
                $res[$value] = get_option($value);
            }
            return $res;
        }

        /**
         * Get Header Theme Options
         * @return array Header Theme Options
         */
        public static function get_header_options()
        {
            return self::get_options(HEADER_OPTIONS);
        }

        /**
         * Get Footer Theme Options
         * @return array Footer Theme Options
         */
        public static function get_footer_options()
        {
            return self::get_options(FOOTER_OPTIONS);
        }

        /**
         * Get options for blog footer
         * @return array Blog footer
         */
        public static function get_blog_footer_options()
        {
            return self::get_options(BLOG_FOOTER_OPTIONS);
        }

        /**
         * Get custom post type posts
         * @param string $post_type
         * @param int $numberposts
         * @param string $order
         * @return int[]|WP_Post[]
         */
        public static function get_cpt_posts($post_type, $numberposts = self::DEFAULT_NUMBERPOSTS, $order = 'ASC')
        {
            return get_posts(array(
                'numberposts' => $numberposts,
                'orderby' => 'date',
                'order' => $order,
                'post_type' => $post_type,
                'suppress_filters' => true,
                'status' => self::STATUS_PUBLISHED,
                'lang' => pll_current_language()
            ));
        }

        /**
         * Get blog posts
         * @param int $numberposts
         * @return WP_Query
         */
        public static function get_blog_posts($numberposts = BLOG_PER_PAGE)
        {
            $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

            $args = array(
                'posts_per_page' => $numberposts,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_type' => 'post',
                'suppress_filters' => true,
                'status' => self::STATUS_PUBLISHED,
                'lang' => pll_current_language()
            );

            return new WP_Query($args);
        }

        /**
         * Get page translations
         * @param $item_id
         * @return array
         */
        public static function get_translations($item_id)
        {
            if (function_exists('pll_get_post_translations')) {
                $translations = pll_get_post_translations($item_id);
                $langs = array();
                foreach ($translations as $key => $value) {
                    array_push(
                        $langs,
                        array(
                            'lang' => strtoupper($key),
                            'href' => get_permalink($value)
                        )
                    );
                }
                return $langs;
            }

            return array();
        }

        /**
         * Get wocommerce main categories
         * @return array
         */
        public static function get_categories()
        {
            return get_categories(array(
                'taxonomy' => self::PRODUCT_CAT,
                'meta_key' => 'number',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'show_count' => 0,
                'pad_counts' => 0,
                'hierarchical' => 0,
                'hide_empty' => 0,
                'parent' => 0,
                'status' => self::STATUS_PUBLISHED
            ));
        }

        /**
         * Get product categories
         * @return array
         */
        public static function auction_categories()
        {
            $terms = get_terms(
                array(
                    'taxonomy' => self::PRODUCT_CAT,
                    'hide_empty' => false,
                    'slug' => 'auction-offers',
                    'parent' => 0
                )
            );

            $parent = 0;
            foreach ($terms as $cat) {
                $parent = $cat->term_id;
                break;
            }

            if (!empty($parent)) {
                return get_terms(array(
                    'taxonomy' => self::PRODUCT_CAT,
                    'meta_key' => 'number',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                    'show_count' => 0,
                    'pad_counts' => 0,
                    'hierarchical' => 0,
                    'hide_empty' => 0,
                    'parent' => $parent,
                    'status' => self::STATUS_PUBLISHED
                ));
            }
            return [];
        }

        /**
         * Get products
         * @return WP_Query
         */
        public static function get_products()
        {
            extract($_GET);

            $per_page = !empty($per_page) ? $per_page : 48;

            $srch = !empty($srch) ? wp_slash($srch) : '';

            $per_page = in_array($per_page, self::PER_PAGE) ? $per_page : self::PRODUCTS_NUMBERPOSTS;
            $height_from = !empty($height_from) ? wp_slash($height_from) : 0;
            $height_to = !empty($height_to) ? wp_slash($height_to) : 99999;

            $price_from = !empty($price_from) ? wp_slash($price_from) : 1;
            $price_to = !empty($price_to) ? wp_slash($price_to) : 99999;
            $meta_query = [];
            $order_by = array_key_exists($sort ?? '', self::ORDER_BY) ? self::ORDER_BY[$sort] : [];

            if (!empty($color)) {
                array_push($meta_query, [
                    'key' => 'product-color',
                    'value' => wp_slash($color),
                    'compare' => 'like'
                ]);
            }

            // Height
            array_push($meta_query, [
                'key' => 'filter-height',
                'value' => array($height_from, $height_to),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ]);

            // Price
            array_push($meta_query, [
                'key' => 'product-price',
                'value' => array($price_from, $price_to),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ]);

            if (!empty($srch))
                array_push($meta_query, [
                    'key' => 'search',
                    'value' => $srch,
                    'compare' => 'LIKE'
                ]);


            $tax_query = [];
            if (!empty(get_queried_object()->slug)) {
                $tax_query = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => self::TAX,
                        'terms' => get_queried_object()->slug,
                        'field' => 'slug',
                        'operator' => 'IN',
                    )
                );
            }

            wp_reset_query();

            $args = array(
                'posts_per_page' => $per_page,
                'orderby' => 'title',
                'order' => 'asc',
                'post_type' => self::PRODUCT,
                'paged' => get_query_var('paged') ?: 1,
                'tax_query' => $tax_query,
                'meta_query' => $meta_query,
                '' => '',
            );

            // exit(var_dump($args));

            if (!empty($order_by)) {
                $args['orderby'] = $order_by['orderby'];
                !empty($order_by['meta_key']) && $args['meta_key'] = $order_by['meta_key'];
                $args['order'] = $order_by['order'];
            }

            return new WP_Query($args);
        }

        /**
         * Get theme option translate by key
         * @param $key
         * @return mixed
         */
        public static function get_option_translate($key)
        {
            $lang = function_exists('pll_current_language') ?
                pll_current_language() : '';

            return get_option("{$key}_{$lang}");
        }

        /**
         * Get price in grn
         * @param float $price
         * @return float
         */
        public static function get_price_grn($price)
        {
            $euro_course = get_option('euro_course');
            return $euro_course > 0 ? round($price * $euro_course) : round($price);
        }

        /**
         * Check if need show attention popup
         * @return string
         */
        public static function attention_popup()
        {
            if (empty($_SESSION['popup_attention'])) {

                $_SESSION['popup_attention'] = true;

                $time_str = get_option('popup_time');
                [$day_of_week, $time] = explode('.', $time_str);

                $day_of_week = intval(ltrim($day_of_week, 0));
                $current_day_of_week = intval(date('w')) + 1;

                if ($current_day_of_week > $day_of_week)
                    return 'act';

                if ($current_day_of_week >= $day_of_week && time() >= strtotime($time))
                    return 'act';
                return '';
            }

            return '';
        }

        public static function filter_colors()
        {
            $colors = [];
            $colors_str = get_option('color_filters');
            if (!empty($colors_str))
                $colors = explode(';', $colors_str);

            sort($colors);
            return $colors;
        }

        /**
         * Get basket items
         * @param $cart
         * @return array|int[]|WP_Post[]
         */
        public static function get_cart_items($cart = null)
        {
            $cart = empty($cart) ? ($_SESSION['cart'] ?? null) : $cart;

            if (!isset($_SESSION) || empty($cart))
                return [];

            $ids = [];
            foreach ($cart as $product_id => $count) {
                array_push($ids, $product_id);
            }

            // $args = array(
            //     'post_type' => 'product',
            //     'post__in' => $ids
            // );

            $items = get_posts(array(
                'numberposts' => -1,
                'category'    => 0,
                // 'orderby'     => 'date',
                // 'order'       => 'DESC',
                'include'     => $ids,
                // 'exclude'     => array(),
                'meta_key'    => '',
                'meta_value'  => '',
                'post_type'   => 'product',
                'suppress_filters' => true,
            ));

            foreach ($items as $item) {
                $item->count = $cart[$item->ID];
                $item->color = get_field('product-color', $item->ID);
                $item->height = get_field('product-height', $item->ID);
                $item->height_filter = get_post_meta($item->ID, 'filter-height', true);
                $item->price = get_field('product-price', $item->ID);
                $item->min_count = get_field('product-minimum-quantity-to-order', $item->ID);
            }
            return $items;
        }

        public  static function filters_act()
        {
            return (int)((int)!empty($_GET['color']) + (int)!empty($_GET['height_from']) +
                (int)!empty($_GET['height_to']) + (int)!empty($_GET['price_from']) +
                (int) !empty($_GET['price_to']) + (int)!empty($_GET['sort']) + (int)!empty($_GET['srch'])) > 0;
        }
    }
}
