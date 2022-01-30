<?php
/**
 * Template Name: Забыли пароль
 */

$key = $_GET['key'] ?? null;
if (!empty($key)) {
    $email = base64_decode($key);
    $user = get_user_by('email', $email);
    if (empty($user))
        unset($email);
}

get_header();
View::render_breadcrumbs(); ?>
    <main class="auth content">
        <div class="container auth__container">
            <?php if (isset($email)): ?>
                <h2 class="auth__title"><?php pll_e('Восстановление пароля'); ?></h2>
            <?php else: ?>
                <h2 class="auth__title"><?php pll_e('Забыли пароль'); ?></h2>
            <?php endif; ?>
            <form class="auth__form jsForm" action="<?= ADMIN_AJAX; ?>" method="post">
                <input type="hidden" name="action" value="auth">
                <input type="hidden" name="type" value="<?= isset($email) ? 'restore_pass' : 'forgot_pass'; ?>">

                <?php if (isset($email)): ?>
                    <input type="hidden" name="email" value="<?= $email; ?>">
                    <input class="auth__input" type="password" name="password" value=""
                           placeholder="<?php pll_e('Пароль') ?>">
                    <input class="auth__input" type="password" name="confirm_password" value=""
                           placeholder="<?php pll_e('Подтвердите пароль') ?>">
                <?php else: ?>
                    <input class="auth__input" name="email" type="email" placeholder="<?php pll_e('Ваш Email'); ?>"
                           required>
                <?php endif; ?>

                <!--TODO: need style errors-->
                <div class="errorBlock" hidden>
                    <ul class="errorList">
                    </ul>
                </div>

                <div class="auth__btns">
                    <button type="submit" class="btn--fill auth__btn"><?php pll_e('Отправить'); ?></button>
                    <a class="btn--border auth__btn"
                       href="<?= site_url('register/'); ?>"><?php pll_e('Регистрация'); ?></a>
                </div>
            </form>
        </div>
    </main>

    <div class="popup popup-status alertMsg">
        <div class="popup__container popup-status__container">
            <h3 class="popup-status__title"><?php pll_e('Успех') ?>!</h3>
            <p class="popup-status__text">
                <span class="new-line">Проверьте пожалуйста ваш email.</span>
                Инструкции по смене пароля были высланы на ваш email.
            </p>
            <a class="btn--gradient popup__close popup-status__submit" href="#">Ок</a>
        </div>
    </div>

<?php get_footer();