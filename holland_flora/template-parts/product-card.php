<?php global $post;
$min_count = get_field('product-minimum-quantity-to-order', $post->ID);
$color = get_field('product-color', $post->ID);
$height = get_field('product-height', $post->ID);
$price = get_field('product-price', $post->ID);
$code = get_post_meta($post->ID, 'code', true);
$img = get_the_post_thumbnail_url($post->ID);
global $counter;
if($price > 0){
  $counter++;
  ?>
  <div class="products-inside__item productItem">
    <div class="products-inside__img-wrap productCart" data-code="<?= $code; ?>" data-popup-trigger="popupProduct" data-id="<?= $post->ID; ?>" data-name="<?= $post->post_title; ?>" data-min="<?= $min_count; ?>" data-img="<?= $img; ?>" data-color="<?= $color; ?>" data-height="<?= $height; ?>" data-price="<?= Helper::get_price_grn($price); ?>">
      <img class="products-inside__img" src="<?= $img; ?>" alt="<?= $post->post_title; ?>">
      <div class="products-inside__loupe">
        <svg class="svg-sprite-icon icon-zoom products-inside__icon">
          <use xlink:href="<?= __SVG__ . '#zoom'; ?>"></use>
        </svg>
      </div>
    </div>
    <div class="products-inside__content">
      <p class="products-inside__id"><?= pll__('Код товара') . ':' . $code; ?></p>
      <a href="<?php echo the_permalink();?>"><h3 class="products-inside__name"><?= $post->post_title; ?></h3></a>
      <p class="products-inside__option"><?php pll_e('Мин. кол-во'); ?>:
        <strong class="js-counterMinValue"><?= $min_count; ?></strong>
      </p>
      <p class="products-inside__option"><?php pll_e('Цвет'); ?>:
        <strong><?= $color; ?></strong>
      </p>
      <p class="products-inside__option"><?php pll_e('Высота'); ?>:
        <strong><?= $height; ?></strong>
      </p>
      <div class="products-inside__wrap">
        <div class="products-inside__col">
          <p class="products-inside__price">
            <span class="currentPrice"><?= Helper::get_price_grn($price); ?></span>
            <?php pll_e('грн./шт.'); ?>
          </p>
          <p class="products-inside__ppc">
            <span class="countPrice"><?= Helper::get_price_grn($price * $min_count); ?></span>
            <?php pll_e('грн./лот.'); ?>
          </p>
        </div>
        <div class="counter" data-min-value="<?= $min_count; ?>">
          <button class="counter__btn changeCountBtn" type="button" data-counter-trigger="minus"></button>
          <input class="counter__input itemsCount" type="number" value="<?= $min_count; ?>" readonly>
          <button class="counter__btn changeCountBtn" type="button" data-counter-trigger="plus"></button>
        </div>
      </div>

      <?php View::render_add_to_cart_form($post->ID, $min_count); ?>
    </div>
  </div>

  <?php
}
?>


