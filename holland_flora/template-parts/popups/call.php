<div class="popup popup-call" data-form="call" data-popup-content="popupCall">
    <div class="popup__container popup-call__container">
        <button class="popup__close popup-call__close" type="button"></button>
        <p class="popup-call__title"><?php pll_e('Перезвоните мне'); ?></p>
        <p class="popup-call__text"><?php pll_e('Введите ваши данные, для того чтобы мы могли с Вами связаться'); ?></p>
        <form id="call" action="<?= ADMIN_AJAX; ?>" method="post" class="popup-call__form jsForm">
            <input type="hidden" name="action" value="<?= App::ACTION; ?>">
            <label class="popup-call__wrap">
                <span class="popup-call__label"><?php pll_e('Ваше имя'); ?></span>
                <input name="name" class="popup-call__input" type="text" required>
            </label>
            <label class="popup-call__wrap">
                <span class="popup-call__label"><?php pll_e('Телефон'); ?></span>
                <input name="tel" class="popup-call__input" type="tel" required>
            </label>
            <button class="btn--fill popup-call__btn" type="submit"><?php pll_e('Отправить'); ?></button>
        </form>
    </div>
</div>