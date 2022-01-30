<div class="chat" data-form="chat">
    <button class="chat__btn" type="button">
        <svg class="svg-sprite-icon icon-chat chat__icon">
            <use xlink:href="<?= __SVG__ . '#chat'; ?>"></use>
        </svg>
    </button>
    <form id="chat" action="<?= ADMIN_AJAX; ?>" method="post" class="chat__form jsForm">
        <input type="hidden" name="action" value="<?= App::ACTION; ?>">
        <div class="chat__header">
            <h3 class="chat__title"><?php pll_e('Поддержка'); ?></h3>
            <button class="chat__close" type="button"></button>
        </div>
        <input class="chat__input" type="text" name="name" placeholder="<?php pll_e('Ваше имя'); ?>" required>
        <input class="chat__input" type="email" name="email" placeholder="<?php pll_e('Ваш Email'); ?>" required>
        <textarea name="msg" class="chat__input chat__textarea" placeholder="<?php pll_e('Ваше сообщение'); ?>"
                  required></textarea>
        <button class="btn--fill chat__submit" type="submit"><?php pll_e('Отправить'); ?></button>
    </form>
</div>