<?php

/**
 * Template Name: Доставка и оплата
 */
get_header(); ?>
<?php View::render_breadcrumbs(); ?>
    <main class="service content">
        <div class="container service__container">
            <div class="service__content">
                <div class="service__col">
                    <h2 class="service__title"><?= get_field("title_1"); ?></h2>
                    <p class="service__text"><?= get_field("short_desc_1"); ?></p>
                    <p class="service__text"><?= get_field("short_desc_1_1"); ?></p>
                </div>
                <div class="service__col">
                    <h2 class="service__title"><?= get_field("title_2"); ?></h2>
                    <p class="service__text"><?= get_field("short_desc_2"); ?></p>
                    <?php View::render_service_features_list(); ?>
                    <p class="service__text"><?= get_field("short_desc_2_1"); ?></p>
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
