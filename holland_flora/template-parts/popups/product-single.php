<div class="popup popup-product popupProduct productItem" data-popup-content="popupProduct">
    <div class="popup__container popup-product__container">
        <img class="popup-product__img popupProductImg" src="" alt="">
        <div class="popup-product__content">
            <button class="popup__close popup-product__close" type="button"></button>
            <p class="popup-product__code"><?php pll_e('Код товара'); ?>: <span class="productCode"></span></p>
            <p class="popup-product__title popupProductName"></p>
            <div class="popup-product__values">
                <p class="popup-product__row">
                    <span class="popup-product__option"><?php pll_e('Мин. кол-во'); ?>:</span>
                    <span class="popup-product__value">
                        <span class="js-counterMinValue popupProductMin"></span><?php pll_e('шт.'); ?>
                    </span>
                </p>
                <p class="popup-product__row">
                    <span class="popup-product__option"><?php pll_e('Цвет'); ?>:</span>
                    <span class="popup-product__value popupProductColor"></span>
                </p>
                <p class="popup-product__row">
                    <span class="popup-product__option"><?php pll_e('Высота'); ?>:</span>
                    <span class="popup-product__value popupProductHeight"></span>
                </p>
            </div>
            <p class="popup-product__price">
                <span class="popup-product__price-item">
                    <span class="currentPrice"></span>
                    <?php pll_e('грн/шт.'); ?>
                </span>
                <span class="popup-product__price-item">
                    <span class="countPrice"></span>
                    <?php pll_e('грн/лот'); ?>
                </span>
            </p>
            <div class="popup-product__wrap">
                <div class="counter counterMinVal" data-min-value="">
                    <button class="counter__btn changeCountBtn" type="button" data-counter-trigger="minus"></button>
                    <input class="counter__input itemsCount" type="number" value="" readonly>
                    <button class="counter__btn changeCountBtn" type="button" data-counter-trigger="plus"></button>
                </div>

                <?php View::render_add_to_cart_form(); ?>

            </div>
        </div>
    </div>
</div>