<?php $options = Helper::get_footer_options(); ?>
<footer class="footer">
    <div class="container footer__container">
        <a class="footer-phone mobi" href="tel:<?= $options['phone']; ?>">
            <svg class="svg-sprite-icon icon-phone footer-phone__icon">
                <use xlink:href="<?= __SVG__ . '#phone'; ?>">
                </use>
            </svg>
            <?= $options['phone']; ?>
        </a>
        <button type="button" class="footer__call mobi" data-popup-trigger="popupCall"><?php pll_e('Заказать звонок'); ?></button>
        <a href="<?php echo get_home_url(null, '/'); ?>">
            <img class="footer__logo logo" src="<?= __IMAGES_DIR__ . 'common/logo.png'; ?>" alt="Holland Flora Logo">
        </a>
        <div class="footer__wrap">
            <?php View::render_menu(FOOTER_MENU); ?>
            <div class="footer__row">
                <a class="footer-phone desktop" href="tel:<?= $options['phone']; ?>">
                    <svg class="svg-sprite-icon icon-phone footer-phone__icon">
                        <use xlink:href="<?= __SVG__ . '#phone'; ?>">
                        </use>
                    </svg>
                    <?= $options['phone']; ?>
                </a>
                <a class="footer__call desktop" href="#"
                   data-popup-trigger='popupCall'><?php pll_e('Заказать звонок'); ?></a>
                <div class="socials footer__socials">
                    <?php View::footer_socials(['facebook' => $options['facebook'], 'insta' => $options['insta'], 'youtube' => $options['youtube']]); ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php
get_template_part('template-parts/chat');
get_template_part('template-parts/popups/call');
get_template_part('template-parts/popups/success');
get_template_part('template-parts/popups/error');
wp_footer(); ?>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    window.addEventListener( "pageshow", function ( event ) {
      var historyTraversal = event.persisted ||
        ( typeof window.performance != "undefined" &&
          window.performance.navigation.type === 2 );
      if ( historyTraversal ) {
        // Handle page restore.
        window.location.reload();
      }
    });
  });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        hideRoseEquador();
        hidePrices();
        hideProductPrices();
    });
   function hidePrices() {
        var isCatalogPage = location.pathname.includes('type');
        var isEquadorPage = location.pathname.includes('type/rose-ecuador');
        if (isEquadorPage || !isCatalogPage) return;
        document.querySelectorAll('.products-inside__content').forEach(function (content){
            content.querySelector('.products-inside__option').style.display = 'none';
        });
        document.querySelectorAll('.popup-product__values').forEach(function (content){
            content.querySelector('.popup-product__row').style.display = 'none';
        })
        document.querySelectorAll('.products-inside__wrap .counter, .jsForm, .popup-product__wrap').forEach(function(pricesBlock) {
            pricesBlock.style.display = 'none';
        });
    }
    function hideProductPrices() {
        var isProductPage = location.pathname.includes('product');
        var isEqProductPage = location.pathname.includes('rosa-ec');
        if (!isProductPage || isEqProductPage) return;
        var hideElements = ['.signle__product-order', '.product__data-line:first-child', '.single__product-same'];
        hideElements.forEach(function(element) {
            document.querySelector(element).style.display = 'none';
        });
    }

    function hideRoseEquador() {
        var isShopPage = location.pathname.includes('shop');
        if (!isShopPage) return;
        document.querySelector('.products-list__item:nth-child(2)').style.display = 'none';
    }
</script>
</body>
</html>
