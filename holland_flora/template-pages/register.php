<?php



/**

 * Template Name: Регистрация

 */



$user = wp_get_current_user();

if (!empty($user) && !empty($user->ID)) {

    wp_safe_redirect('/profile/');

}



get_header();

View::render_breadcrumbs(); ?>

<main class="auth content">

    <div class="container auth__container">

        <h2 class="auth__title"><?php pll_e('Зарегистрироваться'); ?></h2>

        <form action="<?= ADMIN_AJAX; ?>" method="post" class="auth__form jsForm" id="register-form">

            <input type="hidden" name="action" value="auth">

            <input type="hidden" name="type" value="register">



            <input class="auth__input" name="login" type="text" placeholder="<?php pll_e('Логин'); ?>" value="" required>



            <input class="auth__input" name="full_name" type="text" placeholder="<?php pll_e('ФИО'); ?>" value="" required>

            <input class="auth__input" name="tel" type="tel" placeholder="<?php pll_e('Телефон'); ?>" value="" required>

            <input class="auth__input" name="email" type="email" placeholder="Email" value="" required>

            <input class="auth__input" name="company" type="text" placeholder="<?php pll_e('Название вашей фирмы'); ?>" value="" required>

            <div class="auth-dropdown">

                <div class="auth-dropdown__current-wrap">

                    <input name="business" class="auth-dropdown__current" type="text" placeholder="<?php pll_e('Тип бизнеса'); ?>" readonly required value="">

                    <svg class="svg-sprite-icon icon-arrow auth-dropdown__icon">

                        <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>

                    </svg>

                </div>

                <ul class="auth-dropdown__list">

                    <?php View::render_business_type_items(); ?>

                </ul>

            </div>

            <input class="auth__input" name="country" required type="text" placeholder="<?php pll_e('Город'); ?>" value="">

            <input class="auth__input" name="address" type="text" placeholder="<?php pll_e('Адрес доставки'); ?>" value="">

            <input class="auth__input" name="password" required type="password" placeholder="<?php pll_e('Пароль'); ?>">





            <!--TODO: need style errors-->

            <div class="errorBlock" hidden>

                <ul class="errorList">

                </ul>

            </div>





            <label class="auth-checkbox">

                <input class="auth-checkbox__input auth-checkbox__input--policy" type="checkbox">

                <span class="auth-checkbox__label">

                    <span><?php pll_e('Ознакомился с'); ?>

                        <a class="auth-checkbox__link" href="https://hollandflora.com.ua/user-agreement/" rel="nofollow" target="_blank"><?php pll_e('Пользовательским соглашением'); ?></a>

                    </span>

                </span>

            </label>

            <button class="btn--fill auth__submit" type="submit" data-error-msg="<?php pll_e('Ознакомтесь с Пользовательским соглашением'); ?>" disabled><?php pll_e('Зарегистрироваться'); ?>

            </button>

            <p class="auth__login"><?php pll_e('Уже зарегистрированы'); ?>?

                <a class="auth__link" href="<?= get_page_url_by_template_name('template-pages/login'); ?>">

                    <?php pll_e('Авторизуйтесь'); ?>!</a>

            </p>

        </form>



    </div>

  <div class="popup popup-call popup-success-register" id="popup-success-register">
    <div class="popup__container popup-status__container" style="border: 1px solid rgba(0,0,0,0.2); padding: 40px">
      <h3 class="popup-status__title popupTitle">Cпасибо за регистрацию!</h3>
      <p class="popup-status__text">
        <span class="new-line msgTitle">пожалуйста ожидайте звонка менеджера или письмо с инструкцией на указаную вами почту.</span>
      </p>
      <a href="<?= site_url('/'); ?>" class="btn--gradient popup__close popup-status__submit">Ок</a>
    </div>
  </div>

</main>



<?php get_footer();

