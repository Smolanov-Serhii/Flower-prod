<?php
$tax = $wp_query->get_queried_object();

$loop = Helper::get_products();
$current_page = get_query_var('paged') ?: 1;
$tax_permalink = tax_permalink();
$per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : Helper::PRODUCTS_NUMBERPOSTS;

$filters = '&color=' . $_GET['color'] . '&height_from=' . $_GET['height_from'] . '&height_to=' . $_GET['height_to'] . '&price_from=' . $_GET['price_from']
  . '&price_to=' . $_GET['price_to'] . '&sort=' . $_GET['sort'];

get_header(); ?>
<section class="hero">
  <img src="<?= __IMAGES_DIR__ . 'common/hero-bg.jpg'; ?>" aria-hidden="true" class="hero__bg">
  <div class="container hero__container">
    <div class="hero__content">
      <div class="breadcrumbs hero__breadcrumbs">
        <a class="breadcrumbs__item" href="<?= site_url('/'); ?>"><?php pll_e('Главная'); ?></a>
        <a class="breadcrumbs__item" href="<?= site_url('shop/'); ?>"><?php pll_e('Магазин'); ?></a>
        <span class="breadcrumbs__item"><?= $tax->name; ?></a>
      </div>
      <h1 class="hero__title"><?= $tax->name; ?></h1>
    </div>
  </div>
</section>
<main class="products content" data-act-filters="<?= Helper::filters_act(); ?>">
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
<?php get_template_part('template-parts/popups/add_to_cart/info');
get_footer();
