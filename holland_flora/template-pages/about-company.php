<?php

/**
 * Template Name: О компании
 */
get_header(); ?>
<?php View::render_breadcrumbs(); ?>
    <main class="about-company content">
        <div class="container about-company__container">
            <div class="about-company__wrap">
                <div class="about-company__content">
                    <p class="about-company__text"><?= get_field("desc_1"); ?></p>
                    <p class="about-company__text"><?= get_field("desc_2"); ?></p>
                    <ul class="about-company-list">
                        <li class="about-company-list__item">
                            <img class="about-company-list__icon" src="<?= get_field("feature_img_1"); ?>"
                                 alt="">
                            <h3 class="about-company-list__title"><?= get_field("feature_1"); ?></h3>
                        </li>
                        <li class="about-company-list__item">
                            <img class="about-company-list__icon" src="<?= get_field("feature_img_2"); ?>"
                                 alt="">
                            <h3 class="about-company-list__title"><?= get_field("feature_2"); ?></h3>
                        </li>
                        <li class="about-company-list__item">
                            <img class="about-company-list__icon" src="<?= get_field("feature_img_3"); ?>"
                                 alt="">
                            <h3 class="about-company-list__title"><?= get_field("feature_3"); ?></h3>
                        </li>
                    </ul>
                    <a class="btn--gradient about-company__btn" href="#" data-popup-trigger="popupCall"><?php pll_e('Заказать звонок'); ?></a>
                </div>
                <div class="about-company__img-wrap">
                    <img class="about-company__img" src="<?= get_field("img"); ?>" alt="">
                </div>
            </div>
        </div>
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

        <section class="map">
            <div class="container map__container">
                <div class="map-sticker">
                    <h2 class="main__title map-sticker__title"><?= get_field("ov_title"); ?></h2>
                    <p class="map-sticker__descr"><?= get_field("ov_desc"); ?></p>
                    <div class="map-sticker__contacts">
                        <a class="map-sticker__link" href="tel:+380631358182"><?= get_field("ov_phone"); ?></a>
                        <div class="map-socials">
                            <svg class="svg-sprite-icon icon-viber map-socials__icon">
                                <use xlink:href="<?= __SVG__ . '#viber'; ?>"></use>
                            </svg>
                            <svg class="svg-sprite-icon icon-telegram map-socials__icon">
                                <use xlink:href="<?= __SVG__ . '#telegram'; ?>"></use>
                            </svg>
                            <svg class="svg-sprite-icon icon-whatsapp map-socials__icon">
                                <use xlink:href="<?= __SVG__ . '#whatsapp'; ?>"></use>
                            </svg>
                        </div>
                        <a class="map-sticker__link" href="mailto:sales@htu.com.ua"><?= get_field("ov_email"); ?></a>
                    </div>
                    <div class="map-sticker__adress">
                        <svg class="svg-sprite-icon icon-pointer map-sticker__icon">
                            <use xlink:href="<?= __SVG__ . '#pointer'; ?>"></use>
                        </svg>
                        <p class="map-sticker__text"><?= get_field("ov_address"); ?></p>
                    </div>
                </div>
            </div>
            <div class="map__frame">
                <?= get_field('g_maps'); ?>
            </div>
        </section>

    </main>
<?php get_footer();
