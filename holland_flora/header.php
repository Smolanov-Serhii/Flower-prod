<?php $options = Helper::get_header_options();
$user = wp_get_current_user();
$links = Helper::get_translations(get_the_ID());
$current_lang = strtoupper(pll_current_language());

$title = get_the_title();
$items_count = count(Helper::get_cart_items());

if (is_archive())
  $title = null; ?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">

  <?php if (empty($title)) : ?>
    <title><?php the_archive_title() ?></title>
  <?php else : ?>
    <title><?= $title; ?></title>
  <?php endif; ?>

  <?php wp_head(); ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="theme-color" content="#fff">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
  <style>.products-inside__ppc{
    text-indent: -99999px;
    opacity: 0;
    visibility: hidden;
  }
  .popup-product__price .popup-product__price-item:after{
    display: none;
  }
  .popup-product__price .popup-product__price-item:nth-child(2){
    text-indent: -99999px;
    opacity: 0;
    visibility: hidden;
  }
  </style>
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/dist/products-styles.min.css">
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-211276571-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-211276571-1');
  gtag('config', 'AW-448987243');
</script>


</head>

<body>
  <div class="page">
    <header class="header fix-block">
      <div class="container header__container">
        <button class="hamburger" type="button">
          <span class="hamburger__line"></span>
        </button>
        <a href="<?php echo get_home_url(null, '/'); ?>">
          <img class="header__logo logo" src="<?= __IMAGES_DIR__ . 'common/logo.png'; ?>" alt="Holland Flora Logo">
        </a>
        <div class="header__wrap">
          <div class="header__wrap-inside">
            <div class="header__row">
              <div class="header__col">
                <a class="header__call" href="#" data-popup-trigger='popupCall'><?php pll_e('Заказать звонок'); ?></a>
                <a class="header-phone" href="tel:<?= $options['phone']; ?>">
                  <svg class="svg-sprite-icon icon-phone header-phone__icon">
                    <use xlink:href="<?= __SVG__ . '#phone'; ?>"></use>
                  </svg>
                  <?= $options['phone']; ?>
                </a>
              </div>
              <div class="header__col">
                <?php if (!empty($user) && !empty($user->ID)) : ?>
                  <div class="header-action">
                    <a class="header-action__link" rel="nofollow" href="<?= site_url('profile/'); ?>">
                      <div class="header-action__icon-wrap">
                        <svg class="svg-sprite-icon icon-user header-action__icon">
                          <use xlink:href="<?= __SVG__ . '#user'; ?>"></use>
                        </svg>
                      </div>
                      <span class="header-action__link-name"><?= $user->user_login; ?></span>
                    </a>
                    <form action="<?= ADMIN_AJAX; ?>" method="post">
                      <input type="hidden" name="action" value="auth">
                      <input type="hidden" name="type" value="logout">
                      <button class="header-action__logout" type="submit">
                        <svg class="svg-sprite-icon icon-user">
                          <use xlink:href="<?= __SVG__ . '#logout'; ?>"></use>
                        </svg>
                      </button>
                    </form>
                  </div>
                <?php else : ?>
                  <a class="header-action" rel="nofollow" href="<?= get_page_url_by_template_name('template-pages/login'); ?>">
                    <?php pll_e('Войти'); ?>
                    <div class="header-action__icon-wrap">
                      <svg class="svg-sprite-icon icon-user header-action__icon">
                        <use xlink:href="<?= __SVG__ . '#user'; ?>"></use>
                      </svg>
                    </div>
                  </a>
                <?php endif; ?>
                <a class="header-action desktop" href="<?= get_permalink(get_page_by_title('Корзина')); ?>" rel="nofollow">
                  <?php pll_e('Корзина'); ?>
                  <div class="header-action__icon-wrap header-action__icon-basket basketCount act" <?= $items_count > 0 ? "data-basket-value='{$items_count}'" : ''; ?>>
                    <svg class="svg-sprite-icon icon-basket header-action__icon">
                      <use xlink:href="<?= __SVG__ . '#basket'; ?>"></use>
                    </svg>
                  </div>
                </a>
              </div>
<!--              <div class="lang header__lang">-->
<!--                <div class="lang__current-wrap">-->
<!--                  <input class="lang__current" type="text" value="--><?//= $current_lang; ?><!--" readonly>-->
<!--                  <svg class="svg-sprite-icon icon-arrow lang__icon">-->
<!--                    <use xlink:href="--><?//= __SVG__ . '#arrow'; ?><!--"></use>-->
<!--                  </svg>-->
<!--                </div>-->
<!--                <ul class="lang__list">-->
<!--                  --><?php //foreach ($links as $item) : ?>
<!--                    <li class="lang__item"><a href="--><?//= $item['href']; ?><!--">--><?//= $item['lang']; ?><!--</a></li>-->
<!--                  --><?php //endforeach; ?>
<!--                </ul>-->
<!--              </div>-->
            </div>
            <div class="header__row">
              <?php View::render_menu(HEADER_MENU); ?>
              <button class="hamburger" type="button">
                <span class="hamburger__line"></span>
              </button>
            </div>
          </div>
        </div>
        <a class="header-action mobi" href="<?= get_permalink(get_page_by_title('Корзина')); ?>">
          <div class="header-action__icon-wrap header-action__icon-basket basketCount act" <?= $items_count > 0 ? "data-basket-value='{$items_count}'" : ''; ?>>
            <svg class="svg-sprite-icon icon-basket header-action__icon">
              <use xlink:href="<?= __SVG__ . '#basket'; ?>"></use>
            </svg>
          </div>
        </a>
      </div>
    </header>
