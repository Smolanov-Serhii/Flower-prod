<?php
if (!class_exists('View')) {
    class View
    {
        /**
         * Render Socials
         * @param array Socials
         * @return void
         */
        public static function footer_socials($socials)
        {
            $res = "";
            foreach ($socials as $key => $value) {
                $svg = __SVG__ . "#{$key}";
                $res .= "<a class=\"socials__link\" href=\"{$value}\" target=\"_blank\" rel=\"nofollow\">
                        <svg class=\"svg-sprite-icon icon-facebook socials__icon\"><use xlink:href=\"{$svg}\"></use></svg></a>";
            }

            echo $res;
        }


        /**
         * @param string $menu_slug Menu Slug
         * @return void
         */
        public static function render_menu($menu_slug)
        {
            $items = wp_get_nav_menu_items($menu_slug);
            if ($items && is_array($items)) {
                $class_preffix = $menu_slug === FOOTER_MENU ? 'footer' : 'header';
                $res = "<nav class='{$class_preffix}-nav'>";
                foreach ($items as $item) {
                    $title = pll__($item->title);
                    $res .= "<a class='{$class_preffix}-nav__link' href='{$item->url}'>{$title}</a>";
                }

                $res .= '</nav>';
                echo $res;
            }
        }

        /**
         * Render List Business Type
         * @return void
         */
        public static function render_business_type_items()
        {
            $business_type_str = get_option('business_type');
            if (!empty($business_type_str)) {
                $res = "";
                $business_type_arr = explode(';', $business_type_str);
                foreach ($business_type_arr as $value) {
                    $res .= "<li class='auth-dropdown__item'>{$value}</li>";
                }
                echo $res;
            }
        }

        /**
         * Save profile btn
         * @return void
         */
        public static function render_save_profile_btn()
        {
            $svg = __SVG__ . '#save';
            echo "<button class='profile-info__save piSave' type='submit'>
                    <svg class='svg-sprite-icon icon-save profile-info-icon__save'>
                        <use xlink:href='{$svg}'></use>
                    </svg>
                </button>";
        }

        /**
         * Render FAQ for home page
         * @return void
         */
        public static function render_faq()
        {
            if (function_exists('get_field')) {
                $res = "<ul class=\"faq__list\">";
                $count = 0;
                for ($i = 1; $i <= FAQ_LIMIT; $i++) {
                    $question = get_field("question_${i}");
                    $answer = get_field("answer_${i}");

                    if (!empty($question) && !empty($answer)) {
                        ++$count;
                        $res .= "<li class=\"faq__item\">
                                    <div class=\"faq__header\" data-accordion>
                                        <h3 class=\"faq__subtitle\">{$question}</h3>
                                        <span class=\"faq__icon\"></span>
                                    </div>
                                    <div class=\"faq__content\">{$answer}</div>
                                </li>";
                    }
                }
                $res .= "</ul>";
                echo $count > 0 ? $res : "";
            }

            echo "";
        }


        /**
         * Print slider on home page
         * @param string $media
         */
        public static function render_media_slider($media)
        {
            if (!empty($media)) {
                $res = '';
                $items = explode(';', $media);
                foreach ($items as $item) {
                    $is_youtube = strpos($item, 'www.youtube.com') !== false;
                    $data_youtube = $is_youtube ? "data-youtube-src=\"{$item}\"" : "";
                    $img_src = $is_youtube ? "" : $item;
                    $res .= "<div class=\"main-gallery-swiper__slide swiper-slide\">
                                    <div class=\"main-gallery-swiper__content\" {$data_youtube}\">
                                <img class=\"main-gallery-swiper__img\" src=\"{$img_src}\" alt=\"\"></div>
                        </div>";
                }
                echo $res;
            }
        }

        /**
         * Render order tome list
         */
        public static function render_order_time_list()
        {
            if (function_exists('get_field')) {
                $res = '<ul class="coop-list">';
                for ($i = 1; $i <= ORDER_TIME_LIMIT; $i++) {
                    $item = get_field("list_item_{$i}");
                    $res .= "<li class=\"coop-list__item\">{$item}</li>";
                }
                $res .= '</ul>';
                echo $res;
            }
        }

        /**
         * Render service feature list
         */
        public static function render_service_features_list()
        {
            if (function_exists('get_field')) {
                $res = '<blockquote class="service-quote">';
                for ($i = 1; $i <= SERVICE_FEATURE_LIMIT; $i++) {
                    $item = get_field("feature_{$i}");
                    $res .= " <span class=\"service-quote__text\">{$item}</span>";
                }
                $res .= '</blockquote>';
                echo $res;
            }
        }

        /**
         * Render blog posts pagination
         * @param $wp_query
         * @param $current - Current Page
         * @return void
         */
        public static function render_pagination($wp_query, $current = 1)
        {
            $min_page = 1;
            $max_page = $wp_query->max_num_pages;
            $last_pages = $max_page - 3;

            $argspag = array(
                'base'               => '%_%',
                'format'             => '?page=%#%',
                'total'              => 1,
                'current'            => 0,
                'show_all'           => False,
                'end_size'           => 1,
                'mid_size'           => 2,
                'prev_next'          => True,
                'prev_text'          => __('« Previous'),
                'next_text'          => __('Next »'),
                'type'               => 'plain',
                'add_args'           => False,
                'add_fragment'       => '',
                'before_page_number' => '',
                'after_page_number'  => ''
              );

            if ($max_page <= 1) {
                echo '';
            } else {
                $prev = $current > $min_page;
                $next = $current < $max_page;

                $prevPage = $prev ? $current - 1 : 0;
                $nextPage = $next ? $current + 1 : 0;

                $pages = [];
                for ($i = 1; $i <= $max_page; $i++) {
                    array_push($pages, $i);
                };
               /*  ob_start();  */ ?>
                <?php if ($max_page <= 10) : ?>
                    <div class="pagination">
                        <a href="<?= get_pagenum_link($prevPage); ?>" class="pagination__btn prev" type="button" <?= $prev ? '' : 'disabled'; ?>>
                            <svg class="svg-sprite-icon icon-arrow pagination__arrow">
                                <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                            </svg>
                        </a>
                        <div class="pagination__list">
                            <?php foreach ($pages as $page) : ?>
                                <a class="pagination__item <?= $page === $current ? 'act' : ''; ?>" href="<?=  get_pagenum_link($page); ?>"><?= $page ?></a>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= get_pagenum_link($nextPage); ?>" class="pagination__btn next" type="button" <?= $next ? '' : 'disabled'; ?>>
                            <svg class="svg-sprite-icon icon-arrow pagination__arrow">
                                <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                            </svg>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="pagination">
                        <a href="<?= get_pagenum_link($prevPage); ?>" class="pagination__btn prev" type="button" <?= $prev ? '' : 'disabled'; ?>>
                            <svg class="svg-sprite-icon icon-arrow pagination__arrow">
                                <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                            </svg>
                        </a>
                        <div class="pagination__list">

                            <?php if ($current > 3) : ?>
                                <a class="pagination__item <?= 1 === $current ? 'act' : ''; ?>" href="<?= get_pagenum_link(1); ?>">1</a>
                                <span class="pagination__item">...</span>
                            <?php endif; ?>

                            <?php for ($i = $current - 1; $i < count($pages); $i++) : if ($i === $current + 1) break; ?>
                                <a class="pagination__item <?= $pages[$i] === $current ? 'act' : ''; ?>" href="<?=  get_pagenum_link($pages[$i]);?>"><?= $pages[$i]; ?></a>
                            <?php endfor; ?>
                            <?php if ($current < $last_pages) : ?>
                                <span class="pagination__item">...</span>
                                <?php for ($i = $last_pages; $i < count($pages); $i++) : ?>
                                    <a class="pagination__item <?= $pages[$i] === $current ? 'act' : ''; ?>" href="<?= get_pagenum_link($pages[$i]); ?>"><?= $pages[$i]; ?></a>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                        <a href="<?= get_pagenum_link($nextPage); ?>" class="pagination__btn next" type="button" <?= $next ? '' : 'disabled'; ?>>
                            <svg class="svg-sprite-icon icon-arrow pagination__arrow">
                                <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>

            <?php /* echo ob_get_clean(); */
            }
        }


        public static function render_product_categories_aside()
        {
            $categories = Helper::get_categories();

            /* ob_start(); */ ?>

            <aside class="products-aside" style="display:none;">
                <?php get_template_part('template-parts/filter/search');
                get_template_part('template-parts/filter/mobile'); ?>
                <div class="products-aside__list">
                    <?php foreach ($categories as $key => $category) :
                        if ($category->slug === 'uncategorized') continue;
                        $class = get_field('style', $category);
                        $args = array(
                            'taxonomy' => Helper::PRODUCT_CAT,
                            'meta_key' => 'number',
                            'orderby' => 'meta_value',
                            'order' => 'ASC',
                            'show_count' => 0,
                            'pad_counts' => 0,
                            'hierarchical' => 0,
                            'hide_empty' => 0,
                            'parent' => $category->term_id
                        );
                        $sub_categories = get_categories($args);
                        if (!empty($sub_categories)) : ?>
                            <div class="products-aside-accord">
                                <div class="products-aside-accord__header">
                                    <a href="<?= site_url('shop/'); ?>" class="products-aside-accord__title"><?= $category->name; ?></a>
                                  <button type="button" class="products-aside-accord__btn">
                                    <svg class="svg-sprite-icon icon-arrow products-aside-accord__icon">
                                      <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                                    </svg>
                                  </button>
                                </div>
                                <ul class="products-aside-accord__list">
                                    <?php foreach ($sub_categories as $sub_category) : ?>
                                        <li class="products-aside-accord__item">
                                            <a class="products-aside-accord__link" href="<?= get_category_link($sub_category->term_id); ?>"><?= $sub_category->name; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php else : ?>
                            <a class="products-aside__item <?= !empty($class) ? 'red' : ''; ?>" href="<?= get_category_link($category->term_id); ?>"><?= $category->name; ?></a>
                    <?php endif;
                    endforeach; ?>
                </div>
            </aside>
<?php

           /*  echo ob_get_clean(); */
        }

        /**
         * Render breadcrumbs block
         * @param boolean $blog
         * @return void
         */
        public static function render_breadcrumbs($shop = false, $blog = false)
        {
            $home_url = site_url('/');
            $home_title = pll__('Главная');
            $current_url = get_the_permalink();
            $current_title = get_the_title();
            $hero_bg = __IMAGES_DIR__ . 'common/hero-bg.jpg';
            $blog_link = '';
            $shop_link = '';
            if ($blog) {
                $blog_title = pll__('Блог');
                $blog = site_url('blog/');
                $blog_link = "<a class=\"breadcrumbs__item\" href=\"{$blog}\">{$blog_title}</a>";
                echo "<section class=\"hero\">
                <img src=\"{$hero_bg}\" aria-hidden=\"true\" class=\"hero__bg\">
                <div class=\"container hero__container\">
                    <div class=\"hero__content\">
                        <div class=\"breadcrumbs hero__breadcrumbs\">
                            <a class=\"breadcrumbs__item\" href=\"{$home_url}\">{$home_title}</a>
                            {$blog_link}
                            <a class=\"breadcrumbs__item\" href=\"{$current_url}\">{$current_title}</a>
                        </div>
                        <h1 class=\"hero__title\">{$current_title}</h1>
                    </div>
                </div>
            </section>";
            }
            elseif ($shop) {
                $shop_title = pll__('Магазин');
                $shop = site_url('shop/');
                $shop_link = "<a class=\"breadcrumbs__item\" href=\"{$shop}\">{$shop_title}</a>";
                echo "<section class=\"hero\">
                <img src=\"{$hero_bg}\" aria-hidden=\"true\" class=\"hero__bg\">
                <div class=\"container hero__container\">
                    <div class=\"hero__content\">
                        <div class=\"breadcrumbs hero__breadcrumbs\">
                            <a class=\"breadcrumbs__item\" href=\"{$home_url}\">{$home_title}</a>
                            {$shop_link}
                            <a class=\"breadcrumbs__item\" href=\"{$current_url}\">{$current_title}</a>
                        </div>
                        <h1 class=\"hero__title\">{$current_title}</h1>
                    </div>
                </div>
            </section>";
            } else{
                echo "<section class=\"hero\">
                <img src=\"{$hero_bg}\" aria-hidden=\"true\" class=\"hero__bg\">
                <div class=\"container hero__container\">
                    <div class=\"hero__content\">
                        <div class=\"breadcrumbs hero__breadcrumbs\">
                            <a class=\"breadcrumbs__item\" href=\"{$home_url}\">{$home_title}</a>
                            {$blog_link}
                            <a class=\"breadcrumbs__item\" href=\"{$current_url}\">{$current_title}</a>
                        </div>
                        <h1 class=\"hero__title\">{$current_title}</h1>
                    </div>
                </div>
            </section>";
            }



        }

        /**
         * Render block html
         * @param $wrapper - General block name
         * @param $element - Inner html block
         * @param $text - Text
         * @param [$delimeter = ';']
         * @return void
         */
        public static function render_block($wrapper, $element, $text, $delimeter = ';')
        {
            $wrapper_el = $wrapper[0];
            $wrapper_class = $wrapper[1];
            $element_el = $element[0];
            $element_class = $element[1];

            $res = "<{$wrapper_el} class=\"{$wrapper_class}\">";
            $items = explode($delimeter, $text);
            foreach ($items as $item) {
                $res .= "<{$element_el} class=\"{$element_class}\">{$item}</{$element_el}>";
            }
            $res .= "</{$wrapper_el}>";

            echo $res;
        }

        /**
         * Render add to cart form
         * @param int $product_id
         * @param float $count
         * @return void
         */
        public static function render_add_to_cart_form($product_id = 0, $count = 0)
        {
            $action = ADMIN_AJAX;
            $btn_text = pll__('Добавить в корзину');
            $html = "<form action=\"{$action}\" method=\"post\" class=\"jsForm\">
                        <input type=\"hidden\" name=\"action\" value=\"add_to_cart\">
                        <input type=\"hidden\" class=\"productId\" name=\"product_id\" value=\"{$product_id}\">
                        <input type=\"hidden\" class=\"productCount\" name=\"count\" value=\"{$count}\">
                        <button type=\"submit\" class=\"btn--border products-inside__btn addToCartBtn\">
                            {$btn_text}
                        </button>
                    </form>";

            echo $html;
        }
    }
}
