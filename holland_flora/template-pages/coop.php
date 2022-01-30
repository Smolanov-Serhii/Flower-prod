<?php

/**
 * Template Name: Условия сотрудничества
 */
get_header(); ?>
<?php View::render_breadcrumbs(); ?>
<main class="coop content">
    <div class="container coop__container">
<!--         <h2 class="coop__title"><?= get_field("title"); ?></h2>
        <p class="coop__descr"><?= get_field("short_desc"); ?></p>
        <ul class="coop-steps">
            <li class="coop-steps__item" data-numb-name="<?php pll_e('Шаг'); ?>">
                <h3 class="coop-steps__title"><?= get_field("step_1_title"); ?> <img src="<?= __IMAGES_DIR__ . 'common/arrow-wave-up.png'; ?>" class="coop-steps__title-line" aria-hidden="true"></h3>
                <p class="coop-steps__text"><?= get_field("step_1_desc"); ?></p>
            </li>
            <li class="coop-steps__item" data-numb-name="<?php pll_e('Шаг'); ?>">
                <h3 class="coop-steps__title"><?= get_field("step_2_title"); ?> <img src="<?= __IMAGES_DIR__ . 'common/arrow-wave-up.png'; ?>" class="coop-steps__title-line" aria-hidden="true"></h3>
                <p class="coop-steps__text"><?= get_field("step_2_desc"); ?></p>
            </li>
            <li class="coop-steps__item" data-numb-name="<?php pll_e('Шаг'); ?>">
                <h3 class="coop-steps__title"><?= get_field("step_3_title"); ?></h3>
                <p class="coop-steps__text"><?= get_field("step_3_desc"); ?></p>
            </li>
        </ul> -->
        <div class="coop__wrap">
            <div class="coop__col">
                <p class="coop__text"><?php pll_e('Время для заказа'); ?>:</p>
                <?php View::render_order_time_list(); ?>
            </div>
            <div class="coop-box">
                <div class="coop-box__top">
                    <p class="coop-box__wrap"><?= get_field("block_text_1"); ?></p>
                </div>
                <div class="coop-box__bottom">
                    <div class="coop-box__wrap">
                        <p class="coop-box__text"><?= get_field("block_text_2"); ?></p>
                        <a class="btn--gradient coop-box__btn" href="<?= get_page_url_by_template_name('template-pages/register');  ?>"><?php pll_e('Регистрация'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <p>Посещая сайт и/или регистрируясь на сайте в качестве пользователя, Вы полностью соглашаетесь с
            <a class="coop-link" href="https://hollandflora.com.ua/user-agreement/">Пользовательским соглашением</a>
        </p>
        <br>
        <div class="coop-offer">
            <svg class="svg-sprite-icon icon-hand-shake coop-offer__icon">
                <use xlink:href="<?= __SVG__ . '#hand-shake'; ?>"></use>
            </svg>
            <div class="coop-offer__content">
                <p class="coop-offer__title"><?= get_field("wofc_title"); ?></p>
                <p class="coop-offer__text"><?= get_field("wofc_desc_1"); ?></p>
                <p class="coop-offer__text"><?= get_field("wofc_desc_2"); ?>
                    <a class="coop-offer__link" href="mailto:<?= get_field("wofc_email"); ?>"><?= get_field("wofc_email"); ?></a>
                    <?= get_field("wofc_desc_3"); ?>
                </p>
            </div>
        </div>
    </div>
</main>
<?php get_footer();
