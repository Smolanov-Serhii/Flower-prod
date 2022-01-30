<?php

/**
 * Template Name: Магазин
 */

$categories = Helper::auction_categories();

get_header();
View::render_breadcrumbs(); ?>

<?php if (Helper::filters_act()) : ?>

    <?php $loop = Helper::get_products();
    $filters = '&color=' . $_GET['color'] . '&height_from=' . $_GET['height_from'] . '&height_to=' . $_GET['height_to'] . '&price_from=' . $_GET['price_from']
        . '&price_to=' . $_GET['price_to'] . '&sort=' . $_GET['sort'];
    $per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : Helper::PRODUCTS_NUMBERPOSTS;
    $current_page = get_query_var('paged') ?: 1; ?>
    <main class="products content" data-act-filters="1">
        <div class="container products__container desktop">
            <span class="prInfo" data-url="<?= !empty(get_query_var('term')) ? get_term_link(get_query_var('term'), 'type') : get_permalink() ?>" data-per-page="<?= $_GET['per_page'] ?? ''; ?>"></span>

            <?php View::render_product_categories_aside(); ?>

            <div class="products-inside">

                <?php get_template_part('template-parts/filter/desktop'); ?>

                <div class="products-inside__list productsList">
                    <?php while ($loop->have_posts()) : $loop->the_post();
                        get_template_part('template-parts/product-card');
                    endwhile; ?>
                </div>


                <div class="products-inside__pagination">
                    <?php if ($loop->found_posts > $per_page) :
                        View::render_pagination($loop, $current_page);
                    endif; ?>
                    <div class="products-inside-view">
                        <div class="products-inside-view__current-wrap">
                            <input class="products-inside-view__input" type="text" value="Показать по <?= $per_page; ?> товара на странице" readonly>
                            <svg class="svg-sprite-icon icon-arrow products-inside-view__icon">
                                <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                            </svg>
                        </div>
                        <ul class="products-inside-view__list">
                            <?php foreach (Helper::PER_PAGE as $val) : ?>
                                <li class="products-inside-view__item">
                                    <a href="<?= "{$tax_permalink}?per_page={$val}{$filters}"; ?>" rel="nofollow">
                                        <?= "Показать по {$val} товара на странице"; ?>
                                    </a>

                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>


            </div>
        </div>

    </main>
    <?php get_template_part('template-parts/popups/product-single'); ?>
    <?php get_template_part('template-parts/popups/add_to_cart/info'); ?>
<?php else : ?>

    <main class="products content">
        <div class="container products__container">

        <span class="prInfo" data-url="<?= !empty(get_query_var('term')) ? get_term_link(get_query_var('term'), 'type') : get_permalink() ?>" data-per-page="<?= $_GET['per_page'] ?? ''; ?>"></span>

            <?php View::render_product_categories_aside(); ?>
            <div class="products-list">
                <?php get_template_part('template-parts/filter/desktop'); ?>
                <ul class="products-list__list">
                    <?php foreach ($categories as $category) : ?>
                        <li class="products-list__item">
                            <img src="<?= __IMAGES_DIR__ . 'common/products-list-hover.png'; ?>" aria-hidden="true" class="products-list__item--hover">
                            <a class="products-list__link" href="<?= get_category_link($category->term_id); ?>">
                                <img class="products-list__img" src="<?= get_field('category_image', $category->taxonomy . '_' . $category->term_id); ?>" alt="<?= $category->name; ?>">
                                <h3 class="products-list__title"><?= $category->name; ?></h3>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>

<?php endif; ?>

<?php get_footer();
