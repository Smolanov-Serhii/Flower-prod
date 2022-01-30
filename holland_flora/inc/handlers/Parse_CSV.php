<?php

if (!class_exists('Parse_CSV')) {
    class Parse_CSV
    {
        use Singleton;

        const ACTION = 'parse_csv';

        public static function register()
        {
            $handler = self::get_instance();

            add_action('wp_ajax_' . self::ACTION, [$handler, 'handle']);
            add_action('wp_ajax_nopriv_' . self::ACTION, [$handler, 'handle']);
        }

        public function handle()
        {
            if (!empty($_FILES['file']) && !empty($_FILES['file']['tmp_name']) && !empty($_POST['categories'])) {
                global $wpdb;
                $categories = [];
                foreach ($_POST['categories'] as $cat_id)
                    array_push($categories, $cat_id);

                try {
                    if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
                        $i = 0;
                        while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
                            if ($i === 0) {
                                ++$i;
                                continue;
                            }

                            // $arr = array_map(function ($val) {
                            //     if (!mb_detect_encoding($val, 'UTF-8', true))
                            //         return iconv('CP1251', 'UTF-8', $val);
                            //     return $val;
                            // }, $data);

                            [
                                $name,
                                $minimum_quantity_to_order,
                                $color,
                                $height,
                                $filter_height,
                                $price,
                                $search,
                                $cat,
                                $code,
                            ] = $data;


                            $search_title = wp_slash($name);
                            $post_ID = $wpdb->get_var("
                                select 
                                    ID 
                                from {$wpdb->posts} p left join {$wpdb->prefix}postmeta pm on p.Id = pm.post_id 
                                where post_title = '{$search_title}' and meta_key = 'code' and meta_value = '{$code}';
                            ");

                            if (!empty($post_ID)) {
                                $new_categories = $categories;

                                $terms = get_the_terms($post_ID, 'type');
                                foreach ($terms as $term) {
                                    if (!in_array($term->term_id, $categories)) {
                                        array_push($new_categories, $term->term_id);
                                    }
                                }

                                if (!empty($new_categories) && $new_categories !== $categories) {
                                    // dd($post_ID);
                                    wp_set_post_terms($post_ID, $new_categories, 'type');
                                }

                                continue;
                            }

                            // $search_name = wp_slash($name);
                            $thumbnail_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '{$search_title}' AND post_type = 'attachment' LIMIT 1");

                            $price = str_replace(',', '.', $price);

                            $post_ID = wp_insert_post(array(
                                'post_type' => Product_CPT::NAME,
                                'post_title' => $name,
                                'post_status' => 'publish',
                            ));

                            if (!empty($thumbnail_id))
                                set_post_thumbnail($post_ID, $thumbnail_id);

                            update_post_meta($post_ID, 'product-minimum-quantity-to-order', $minimum_quantity_to_order);
                            update_post_meta($post_ID, 'product-color', $color);
                            update_post_meta($post_ID, 'product-price', floatval($price));
                            update_post_meta($post_ID, 'product-height', $height);
                            update_post_meta($post_ID, 'filter-height', $filter_height);
                            update_post_meta($post_ID, 'search', $search);
                            update_post_meta($post_ID, 'code', $code);

                            if (!empty($categories))
                                wp_set_post_terms($post_ID, $categories, 'type');
                        }
                        fclose($handle);
                    }

                    dd('Готово!');
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            } else {
                echo "Invalid file";
            }

            die;
        }
    }
}
