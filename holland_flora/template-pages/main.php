<?php

/**
 * Template Name: Главная
 */

get_header(); ?>
<section class="hero">
  <img src="<?= __IMAGES_DIR__ . 'common/hero-bg.jpg'; ?>" aria-hidden="true" class="hero__bg">
  <div class="container hero__container">
    <div class="hero__content">
      <h1 class="hero__title hero__title--main"><?= get_field("title"); ?></h1>
      <ul class="hero-features">
        <li class="hero-features__item">
          <img class="hero-features__icon" src="<?= get_field("feature_1_icon"); ?>" alt="">
          <p class="hero-features__label"><?= get_field("feature_1_title"); ?></p>
        </li>
<!--         <li class="hero-features__item">
          <div class="hero-features__wrap">
            <img class="hero-features__icon" src="<?= get_field("feature_2_icon"); ?>" alt="">
            <p class="hero-features__label"><?= get_field("feature_2_title"); ?></p>
          </div>
        </li> -->
        <li class="hero-features__item">
          <div class="hero-features__wrap">
            <img class="hero-features__icon" src="<?= get_field("feature_3_icon"); ?>" alt="">
            <p class="hero-features__label"><?= get_field("feature_3_title"); ?></p>
          </div>
        </li>
      </ul>
		<ul style="display: grid;gap: 20px;grid-template-columns: repeat(auto-fit, minmax(235px, 250px));justify-content: space-around;">

			<li><a title="Здесь вы можете ознакомится с предложениями и ценами аукциона" href="<?= site_url('shop/'); ?>" class="btn--gradient"><?php pll_e('Каталог'); ?></a></li>
      <?php
      if ( is_user_logged_in() ) {
        ?>
          <li><a title="Платформа, на которой вы можете преобрести товар в online режиме" href="https://shop.floraplaza.nl/floraplaza/ru/EUR/login" target="_blank" class="btn--gradient"><?php pll_e('Предзаказ аукциона'); ?></a></li>
        <?php
      } else {
        ?>
          <li><a title="регистрация для работы с магазином" href="<?= site_url('register/'); ?>" target="_self" class="btn--gradient"><?php pll_e('Предзаказ на аукцион'); ?></a></li>
        <?php
      }
      ?>
			<li><a title="Здесь представлен ассортимент плантаций, с которыми мы сотрудничаем" href="<?= site_url('type/rose-ecuador/'); ?>" class="btn--gradient" title="<?php pll_e('Предзаказ у садовников'); ?>"><?php pll_e('Предзаказ у садовников'); ?></a></li>
		</ul>
    </div>
  </div>
</section>

<main class="main content">
  <?php if (!empty($benefits = Helper::get_cpt_posts(Benefit_CPT::NAME))) : ?>
    <section class="main-features">
      <div class="container main-features__container">
        <h2 class="main__title"><?php pll_e('Выгоды'); ?></h2>
        <ul class="main-features__list">
          <?php foreach ($benefits as $benefit) : ?>
            <li class="main-features__item">
              <img class="main-features__icon" src="<?= get_the_post_thumbnail_url($benefit->ID); ?>" alt="<?= $benefit->post_title; ?>">
              <h3 class="main-features__title"><?= $benefit->post_title; ?></h3>
              <p class="main-features__label"><?= $benefit->post_excerpt; ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  <?php endif; ?>
  <section class="main-about">
    <div class="container main-about__container">
      <div class="main-about__content">
        <h2 class="main__title main-about__title"><?php pll_e('О нас'); ?></h2>
        <p class="main-about__text"><?= get_field("about_us"); ?></p>
      </div>
      <img class="main-about__img" src="<?= get_field("about_us_img"); ?>" alt="">
    </div>
  </section>
  <section class="main-advantages">
    <div class="container main-advantages__container">
      <h2 class="main__title"><?php pll_e('Преимущества'); ?></h2>
      <div class="swiper-container main-advantages-swiper">
        <ul class="swiper-wrapper main-advantages-swiper__wrapper">
          <li class="main-advantages-swiper__slide swiper-slide">
            <div class="main-advantages-swiper__bg" style="background-image:url('<?= get_field("advantages_1_img"); ?>')">
              <div class="main-advantages-swiper__content">
                <h3 class="main-advantages-swiper__title"><?= get_field("advantages_1_title"); ?></h3>
                <p class="main-advantages-swiper__text"><?= get_field("advantages_1_desc"); ?></p>
              </div>
            </div>
          </li>
          <li class="main-advantages-swiper__slide swiper-slide">
            <div class="main-advantages-swiper__bg" style="background-image:url('<?= get_field("advantages_2_img"); ?>')">
              <div class="main-advantages-swiper__content">
                <h3 class="main-advantages-swiper__title"><?= get_field("advantages_2_title"); ?></h3>
                <p class="main-advantages-swiper__text"><?= get_field("advantages_2_desc"); ?></p>
              </div>
            </div>
          </li>
          <li class="main-advantages-swiper__slide swiper-slide">
            <div class="main-advantages-swiper__bg" style="background-image:url('<?= get_field("advantages_3_img"); ?>')">
              <div class="main-advantages-swiper__content">
                <h3 class="main-advantages-swiper__title"><?= get_field("advantages_3_title"); ?></h3>
                <p class="main-advantages-swiper__text"><?= get_field("advantages_3_desc"); ?></p>
              </div>
            </div>
          </li>
        </ul>
        <div class="main-advantages-swiper__action">
          <button class="swiper__btn main-advantages-swiper__btn prev" type="button">
            <svg class="svg-sprite-icon icon-arrow-wide swiper__arrow">
              <use xlink:href="<?= __SVG__ . '#arrow-wide'; ?>"></use>
            </svg>
          </button>
          <div class="main-advantages-swiper__pagination"></div>
          <button class="swiper__btn main-advantages-swiper__btn next" type="button">
            <svg class="svg-sprite-icon icon-arrow-wide swiper__arrow">
              <use xlink:href="<?= __SVG__ . '#arrow-wide'; ?>"></use>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </section>
  <section class="main-gallery">
    <div class="container main-gallery__container">
      <div class="main-gallery__info">
        <h2 class="main__title main-gallery__title">
          <span class="c-brown"><?= get_field("gv_title") ?></span>
          <?= get_field("gv_subtitle"); ?>
        </h2>
        <p class="main-gallery__text"><?= get_field("gv_description"); ?></p>
      </div>
      <div class="main-gallery-swiper swiper-container">
        <div class="main-gallery-swiper__wrapper swiper-wrapper">
          <?php View::render_media_slider(get_field("media")); ?>
        </div>
      </div>
      <div class="main-gallery-swiper__action">
        <div class="main-gallery-swiper__action-wrap">
          <button class="swiper__btn main-gallery-swiper__btn prev" type="button">
            <svg class="svg-sprite-icon icon-arrow-wide swiper__arrow">
              <use xlink:href="<?= __SVG__ . '#arrow-wide'; ?>"></use>
            </svg>
          </button>
          <div class="main-gallery__pagination"></div>
          <button class="swiper__btn main-gallery-swiper__btn next" type="button">
            <svg class="svg-sprite-icon icon-arrow-wide swiper__arrow">
              <use xlink:href="<?= __SVG__ . '#arrow-wide'; ?>"></use>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </section>
  <section class="main-steps">
    <div class="container main-steps__container">
      <h2 class="main__title"><?php pll_e('Схема работы'); ?></h2>
      <ul class="main-steps__content">
        <li class="main-steps__item">
          <h3 class="main-steps__subtitle"><?= get_field("work_scheme_1_title"); ?><img src="<?= __IMAGES_DIR__ . 'common/arrow-wave-up.png'; ?>" class="main-steps__subtitle-line" aria-hidden="true"></h3>
          <p class="main-steps__text"><?= get_field("work_scheme_1_desc"); ?></p>
        </li>
        <li class="main-steps__item">
          <h3 class="main-steps__subtitle"><?= get_field("work_scheme_2_title"); ?><img src="<?= __IMAGES_DIR__ . 'common/arrow-wave-down.png'; ?>" class="main-steps__subtitle-line" aria-hidden="true"></h3>
          <p class="main-steps__text"><?= get_field("work_scheme_2_desc"); ?></p>
        </li>
        <li class="main-steps__item">
          <h3 class="main-steps__subtitle"><?= get_field("work_scheme_3_title"); ?></h3>
          <p class="main-steps__text"><?= get_field("work_scheme_3_desc"); ?></p>
        </li>
        <li class="main-steps__item">
          <h3 class="main-steps__subtitle"><?= get_field("work_scheme_4_title"); ?><img src="<?= __IMAGES_DIR__ . 'common/arrow-wave-up.png'; ?>" class="main-steps__subtitle-line" aria-hidden="true"></h3>
          <p class="main-steps__text"><?= get_field("work_scheme_4_desc"); ?></p>
        </li>
        <li class="main-steps__item">
          <h3 class="main-steps__subtitle"><?= get_field("work_scheme_5_title"); ?></h3>
          <p class="main-steps__text"><?= get_field("work_scheme_5_desc"); ?></p>
        </li>
      </ul>
    </div>
  </section>
  <?php if (!empty($reviews = Helper::get_cpt_posts(Review_CPT::NAME))) : ?>
    <section class="main-reviews">
      <div class="main-reviews__bg-wrap">
        <img class="main-reviews__bg" src="<?= get_field("review_img"); ?>" alt="">
      </div>
      <div class="container main-reviews__container">
        <h2 class="main__title"><?php pll_e('Отзывы'); ?></h2>
        <div class="swiper-container main-reviews-swiper">
          <div class="swiper-wrapper main-reviews-swiper__wrapper">
            <?php foreach ($reviews as $review) : ?>
              <div class="swiper-slide main-reviews-swiper__slide">
                <div class="main-reviews-swiper__header">
                  <div class="main-reviews-swiper__img-wrap">
                    <img class="main-reviews-swiper__img" src="<?= get_the_post_thumbnail_url($review->ID); ?>" alt="<?= $review->post_title; ?>">
                  </div>
                  <div class="main-reviews-swiper__about">
                    <p class="main-reviews-swiper__name"><?= $review->post_title; ?></p>
                    <p class="main-reviews-swiper__date"><?= get_the_date('d.m.Y', $review->ID) ?></p>
                  </div>
                </div>
                <p class="main-reviews-swiper__text"><?= $review->post_content; ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="main-reviews__action">
          <button class="swiper__btn main-reviews__btn prev" type="button">
            <svg class="svg-sprite-icon icon-arrow-wide swiper__arrow">
              <use xlink:href="<?= __SVG__ . '#arrow-wide'; ?>"></use>
            </svg>
          </button>
          <div class="main-reviews__pagination"></div>
          <button class="swiper__btn main-reviews__btn next" type="button">
            <svg class="svg-sprite-icon icon-arrow-wide swiper__arrow">
              <use xlink:href="<?= __SVG__ . '#arrow-wide'; ?>"></use>
            </svg>
          </button>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <section class="faq">
    <div class="faq__bg-wrap">
      <img class="faq__bg" src="<?= get_field("faq_img"); ?>" alt="">
    </div>
    <div class="container faq__container">
      <h2 class="main__title"><?php pll_e('Вопросы и ответы'); ?></h2>
      <?php View::render_faq(); ?>
    </div>
  </section>
  <div class="banner-coop">
    <div class="container banner-coop__container">
      <div class="banner-coop__left banner-coop__col">
        <p class="banner-coop__title">
          <span class="banner-coop__title-wrap"><?= get_field("start_cooperation_title"); ?>
            <span class="new-line c-brown"><?= get_field("start_cooperation_subtitle"); ?></span>
          </span>
        </p>
      </div>
      <div class="banner-coop__right banner-coop__col">
        <p class="banne-coop__text"><?= get_field("start_cooperation_desc"); ?></p>
      </div>
    </div>
  </div>
</main>
<div class="popup popup-video" data-popup-content="popupVideo">
  <div class="popup__container popup-video__container">
    <button class="popup__close popup-video__close" type="button"></button>
  </div>
</div>
<?php get_footer();
