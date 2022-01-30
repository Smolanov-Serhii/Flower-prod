<?php

/**
 * Template Name: Корзина
 */

$items = Helper::get_cart_items();
$uri = !empty($_SESSION['redirect_uri']) ? $_SESSION['redirect_uri'] : 'shop/';
get_header();
View::render_breadcrumbs(); ?>
<main class="basket content">
    <div class="container basket__container">
        <form action="<?= ADMIN_AJAX; ?>" method="post" class="basket__content jsForm">
            <input type="hidden" name="action" value="create_order">
            <div class="basket-header">
                <p class="basket-header__numb">№</p>
                <p class="basket-header__name"></p>
                <p class="basket-header__counter"><?php pll_e('Количество'); ?></p>
                <p class="basket-header__pcc"><?php pll_e('Цена за шт'); ?>.</p>
                <p class="basket-header__price"><?php pll_e('Стоимость'); ?></p>
            </div>
            <ul class="basket__list basketList" data-action="<?= ADMIN_AJAX; ?>">
                <?php $sum = 0;
                foreach ($items as $i => $item) : ?>
                    <li class="basket__item productItem">
                        <div class="basket__col">
                            <p class="basket__number"></p>
                            <div class="basket__img-wrap">
                                <img class="basket__img" src="<?= get_the_post_thumbnail_url($item->ID); ?>" alt="<?= $item->post_title; ?>">
                            </div>
                            <div class="basket__wrap">
                                <h3 class="basket__name"><?= $item->post_title; ?></h3>
                                <div class="basket__info">
                                    <p class="basket__option"> <?= pll__('Цвет:') . $item->color; ?></p>
                                    <p class="basket__option"> <?= !empty($item->height_filter) ? (pll__('Высота:') . $item->height_filter . pll__('см')) : pll__('Высота:'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="counter basket__counter" data-min-value="<?= $item->min_count; ?>" data-url="<?= ADMIN_AJAX; ?>" data-id="<?= $item->ID; ?>">
                            <button class="counter__btn changeCountBtn addRemoveItems" type="button" data-counter-trigger="minus"></button>
                            <input class="counter__input itemsCount" type="number" value="<?= $item->count; ?>" readonly>
                            <button class="counter__btn changeCountBtn addRemoveItems" type="button" data-counter-trigger="plus"></button>
                        </div>
                        <p class="basket__price">
                            <span class="basket__price-ppc">
                                <span class="currentPrice"><?= Helper::get_price_grn($item->price); ?></span>
                                <?php pll_e('грн'); ?>.
                                <span class="basket__price-ppc--mobi">/ <?php pll_e('шт'); ?>.</span>
                            </span>
                            <span class="basket__price-total">
                                <?php $price = Helper::get_price_grn($item->count * $item->price);
                                $sum += $price; ?>
                                <span class="countPrice"><?= $price; ?></span>
                                <span class="basket__price--small"><?php pll_e('грн'); ?>.</span>
                            </span>
                        </p>
                        <button class="basket__delete removeFromCart" type="button" data-url="<?= ADMIN_AJAX; ?>" data-body="action=remove_from_cart&p=<?= $item->ID; ?>"></button>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="basket__bottom">
                <div class="basket__total">
                    <p class="basket__label"><?php pll_e('Стоимость заказа:'); ?></p>
                    <p class="basket__price">
                        <span class="totalPrice"><?= $sum; ?></span>
                        <span class="basket__price--small"><?php pll_e('грн.'); ?></span>
                    </p>
                </div>
                <textarea class="basket__textarea" name="comment" placeholder="<?php pll_e('Комментарий к заказу'); ?>"></textarea>
                <div class="basket__action">
                    <button type="submit" class="btn--fill basket__submit">
                        <?php pll_e('Оформить заказ'); ?>
                    </button>
                    <a class="basket__continue" href="<?= site_url($uri); ?>">
                        <?php pll_e('Продолжить покупки'); ?>
                    </a>
                </div>
                <div class="basket-descr">
                    <div class="basket-descr__col">
                        <p class="basket-descr__title"><?= get_field('b_title'); ?></p>
                        <?php View::render_block(['ul', 'basket-descr__list'], ['li', 'basket-descr__item'], get_field('b_list')); ?>
                    </div>
                    <div class="basket-descr__col">
                        <?php View::render_block(['div', 'basket-quote'], ['p', 'basket-quote__text'], get_field('b_desc')); ?>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="popup popup-attention popupAttention <?= Helper::attention_popup(); ?>" data-popup-content="popupAttention">
        <div class="popup__container popup-attention__container">
            <h4 class="popup-attention__title"><?php pll_e('Внимание'); ?>!</h4>
            <p class="popup-attention__text"><?= Helper::get_option_translate('popup_attention'); ?></p>
            <button class="popup__close btn--fill popup-attention__submit popupAttentionBtn" type="button">
                <?php pll_e('Ок'); ?>
            </button>
        </div>
    </div>

    <div class="popup popup-status popupSuccess" data-popup-content="popupSuccess">
        <div class="popup__container popup-status__container">
            <h3 class="popup-status__title">Спасибо!</h3>
            <p class="popup-status__text">
                <span class="new-line">Ваш заказ №
                    <span class="popup-status__id orderId">12345</span> принят.
                </span>
                История ваших заказов вы сможете посмотреть в
                <a class="popup-status__link" href="<?= site_url('profile/'); ?>">
                    личном кабинете
                </a>
            </p>
            <a class="btn--gradient popup__close popup-status__submit" href="<?= site_url('shop/'); ?>">Ок</a>
        </div>
    </div>
	
	<script>
		document.querySelector('.basket__submit').addEventListener('click', function(){
			(function(){
				gtag('event', 'conversion', {'send_to': 'AW-448987243/VsfBCKv4jf8CEOuAjNYB'});
			})()
		});
	</script>

    <div class="popup popup-status popupErrorCart" data-popup-content="popupError">
        <div class="popup__container popup-status__container">
            <h3 class="popup-status__title">Ошибка!</h3>
            <p class="popup-status__text"><span class="new-line">Произошла какая-то ошибка.</span>Пожалуйста
                попробуйте
                оформить заказ еще раз!</p><a class="btn--gradient popup__close popup-status__submit" href="#">Ок</a>
        </div>
    </div>
</main>
<?php get_footer();
