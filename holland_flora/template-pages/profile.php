<?php

/**
 * Template Name: Профиль
 */


$user = wp_get_current_user();
if (empty($user) || empty($user->ID)) {
  wp_safe_redirect(get_page_url_by_template_name('template-pages/login'));
}
$info = get_user_meta($user->ID, Auth::USER_META_KEY, true);


$args = array(
  'author' => $user->ID,
  'orderby' => 'post_date',
  'order' => 'DESC',
  'posts_per_page' => -1,
  'post_type' => Order_CPT::NAME
);

$orders = get_posts($args);

get_header(); ?>
<?php View::render_breadcrumbs(); ?>
<main class="profile content">
  <div class="container profile__container tabs">
    <aside class="profile-aside">
      <ul class="profile-aside__list">
        <li class="profile-aside__item" data-order-number="<?= count($orders); ?>" data-tab-trigger="profileOrders">
          <?php pll_e('Мои заказы'); ?>
        </li>
        <li class="profile-aside__item act" data-tab-trigger="profileInfo"><?php pll_e('Личные данные'); ?></li>
      </ul>
    </aside>
    <div class="profile__content" data-tab-content="profileOrders">
      <table class="profile-order">
        <thead>
          <tr class="profile-order__header">
            <th class="profile-order__header">№ Заказа</th>
            <th class="profile-order__header">Дата</th>
            <th class="profile-order__header">Сумма</th>
            <th class="profile-order__header">Подробнее</th>
          </tr>
        </thead>
        <?php foreach ($orders as $order) : ?>
          <tbody class="profile-order__item">
            <tr class="profile-order__row">
              <td class="profile-order__name center">№<?= $order->ID; ?></td>
              <td class="center"><?= get_the_date('d.m.Y H:i:s', $order); ?></td>
              <td class="center"><?= Helper::get_price_grn(get_post_meta($order->ID, 'order_sum', true)) . ' грн.'; ?></td>
              <td>
                <svg class="svg-sprite-icon icon-arrow profile-order__icon">
                  <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                </svg>
              </td>
            </tr>
            <tr>
              <td colspan="4">
                <div class="profile-order__content">


                  <table class="profile-order-table">
                    <tbody>
                      <tr class="profile-order-table__row">
                        <th class="profile-order-table__head">#</th>
                        <th class="profile-order-table__head"><?php pll_e('Продукт'); ?></th>
                        <th class="profile-order-table__head"></th>
                        <th class="profile-order-table__head">Опции</th>
                        <th class="profile-order-table__head"><?php pll_e('Количество'); ?></th>
                        <th class="profile-order-table__head"><?php pll_e('Цена, грн'); ?></th>
                      </tr>
                      <?php $sum = 0;
                      $cart = get_field('cart', $order->ID);
                      $items = Helper::get_cart_items($cart);
                      foreach ($items as $key => $item) : $sum += $item->count * $item->price; ?>
                        <tr class="profile-order-table__row">
                          <td class="profile-order-table__item"><?= $key + 1; ?></td>
                          <td class="profile-order-table__item">
                            <img src="<?= get_the_post_thumbnail_url($item->ID); ?>" alt="" class="profile-order-table__img">
                          </td>
                          <td class="profile-order-table__item">
                            <a class="profile-order-table__link" href="javascript:;">
                              <?= $item->post_title; ?></a>
                          </td>
                          <td class="profile-order-table__item">
                            <span><?php pll_e('Цвет') ?>: <strong><?= get_field('product-color', $item->ID) ?></strong></span>
                            <span><?php pll_e('Высота') ?>: <strong><?= get_field('product-height', $item->ID) ?></strong></span>
                          </td>
                          <td class="profile-order-table__item"><?= $item->count; ?></td>
                          <td class="profile-order-table__item"><?= Helper::get_price_grn($item->price * $item->count) . ' грн.'; ?> </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>


                  <div class="profile-order__total">
                    <p class="profile-order__label"><?php pll_e('Общая сумма'); ?>:</p>
                    <p class="profile-order__price"><?= Helper::get_price_grn(get_post_meta($order->ID, 'order_sum', true)) . ' грн.'; ?></p>
                  </div>
                  <a class="btn--border profile-order__btn repeatOrder" data-id="<?= $order->ID; ?>" data-url="<?= ADMIN_AJAX; ?>" href="#"><?php pll_e('Повторить заказ'); ?></a>
                </div>
              </td>
            </tr>
          </tbody>
        <?php endforeach; ?>
      </table>
    </div>

    <div class="profile__content act" data-tab-content="profileInfo">
      <div class="profile-info">
        <h3 class="profile__title"><?php pll_e('Личные данные'); ?></h3>
        <form class="profile-info__form piForm" action="<?= ADMIN_AJAX ?>" method="POST">
          <ul class="profile-info__list">
            <li class="profile-info__item piItem" data-key="full_name">
              <div class="profile-info__input-wrap">
                <input class="profile-info__input" name="full_name" type="text" value="<?= $info['full_name'] ?? ''; ?>" readonly>
                <?php View::render_save_profile_btn(); ?>
              </div>
              <button class="profile-info__edit piEdit" type="button"><?php pll_e('Редактировать'); ?></button>
            </li>
            <li class="profile-info__item piItem" data-key="tel">
              <div class="profile-info__input-wrap">
                <input class="profile-info__input" name="tel" type="text" value="<?= $info['tel'] ?? ''; ?>" readonly>
                <?php View::render_save_profile_btn(); ?>
              </div>
              <button class="profile-info__edit piEdit" type="button"><?php pll_e('Редактировать'); ?></button>
            </li>
            <li class="profile-info__item piItem" data-key="company">
              <div class="profile-info__input-wrap">
                <input class="profile-info__input" name="company" type="text" value="<?= $info['company'] ?? ''; ?>" readonly>
                <?php View::render_save_profile_btn(); ?>
              </div>
              <button class="profile-info__edit piEdit" type="button"><?php pll_e('Редактировать'); ?></button>
            </li>
            <li class="profile-info__item piItem" data-key="business">
              <div class="profile-info__input-wrap">
                <input class="profile-info__input" name="business" type="text" value="<?= $info['business'] ?? ''; ?>" readonly>
                <?php View::render_save_profile_btn(); ?>
              </div>
              <button class="profile-info__edit piEdit" type="button"><?php pll_e('Редактировать'); ?></button>
            </li>
            <li class="profile-info__item piItem" data-key="email">
              <div class="profile-info__input-wrap">
                <input class="profile-info__input" name="email" type="email" value="<?= $user->user_email ?>" readonly>
                <?php View::render_save_profile_btn(); ?>
              </div>
              <button class="profile-info__edit piEdit" type="button"><?php pll_e('Редактировать'); ?></button>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</main>
<?php get_footer();
