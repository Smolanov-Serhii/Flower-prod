

<form class="products-aside-search" action="" method="get">

    <input name="srch" class="products-aside-search__input" value="<?= $_GET['srch'] ?? ''; ?>" type="text" placeholder="<?php pll_e('Поиск наименования товара'); ?>">

    <button class="products-aside-search__btn" type="submit">

        <svg class="svg-sprite-icon icon-search products-aside-search__icon">

            <use xlink:href="<?= __SVG__ . '#search'; ?>"></use>

        </svg>

    </button>

</form>
