<?php

/**
 * Template Name: Вход
 */

$user = wp_get_current_user();
if (!empty($user) && !empty($user->ID)) {
    wp_safe_redirect('/profile/');
}

get_header(); ?>
<?php View::render_breadcrumbs(); ?>
    <main class="auth content">
        <div class="container auth__container">
            <h2 class="auth__title"><?php pll_e('Вход в личный кабинет'); ?></h2>
            <form class="auth__form jsForm" method="post" action="<?= ADMIN_AJAX; ?>">
                <input type="hidden" name="action" value="auth">
                <input type="hidden" name="type" value="login">
                <input class="auth__input" name="email" value="" type="text"
                       placeholder="<?php pll_e('Ваш логин'); ?> (Email)" required>
                <input class="auth__input" name="password" type="password" placeholder="<?php pll_e('Пароль'); ?>"
                       required>
                <label class="auth-checkbox">
                    <input class="auth-checkbox__input" name="remember" type="checkbox" checked>
                    <span class="auth-checkbox__label"><?php pll_e('Запомнить меня'); ?></span>
                </label>
                <div class="auth__btns">
                    <button class="btn--fill auth__btn" href="#"> <?php pll_e('Вход'); ?></button>
                    <a class="btn--border auth__btn" rel="nofollow"
                       href="<?= get_page_url_by_template_name('template-pages/register'); ?>"><?php pll_e('Регистрация'); ?></a>
                </div>
                <p class="auth__login"><a class="auth__link"
                                          href="<?= site_url('forgot-pass/'); ?>"><?php pll_e('Забыли пароль?'); ?></a>
                </p>
            </form>


            <!--TODO: need style errors-->
            <div class="errorBlock" hidden>
                <ul class="errorList">
                </ul>
            </div>


        </div>
    </main>

<?php get_footer();
