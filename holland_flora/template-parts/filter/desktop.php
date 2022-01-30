<?php
$color = $_GET['color'] ?? '';
$height_from = $_GET['height_from'] ?? '';
$height_to = $_GET['height_to'] ?? '';
$price_from = $_GET['price_from'] ?? '';
$price_to = $_GET['price_to'] ?? '';
$sort = $_GET['sort'] ?? 'По алфавиту';
$colors = Helper::filter_colors();
?>
<form class="products-filter desktop filtersForm" action="" method="get" style="display: none;">
    <div class="products-filter__col">
        <p class="products-filter__label"><?php pll_e('Цвет'); ?>:</p>
        <div class="products-filter-dropdown">
            <div class="products-filter-dropdown__current-wrap">
                <input class="products-filter-dropdown__input" name="color" type="text" value="<?= $color; ?>" readonly>
                <svg class="svg-sprite-icon icon-arrow products-filter-dropdown__icon">
                    <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                </svg>
            </div>
            <ul class="products-filter-dropdown__list">
                <?php foreach ($colors as $color) : ?>
                    <li class="products-filter-dropdown__item"><?= $color; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="products-filter__col">
        <p class="products-filter__label"><?php pll_e('Высота см'); ?>:</p>
        <div class="products-filter__wrap">
            <label class="products-filter__input-wrap">
                <span class="products-filter__sublabel"><?php pll_e('От'); ?></span>
                <input name="height_from" value="<?= $height_from; ?>" class="products-filter__input" type="number">
            </label>
            <label class="products-filter__input-wrap">
                <span class="products-filter__sublabel"><?php pll_e('До'); ?></span>
                <input name="height_to" value="<?= $height_to; ?>" class="products-filter__input" type="number">
            </label>
        </div>
    </div>
    <div class="products-filter__col">
        <p class="products-filter__label"><?php pll_e('Стоимость грн'); ?>:</p>
        <div class="products-filter__wrap">
            <label class="products-filter__input-wrap">
                <span class="products-filter__sublabel"><?php pll_e('От'); ?></span>
                <input name="price_from" value="<?= $price_from; ?>" class="products-filter__input" type="number">
            </label>
            <label class="products-filter__input-wrap">
                <span class="products-filter__sublabel"><?php pll_e('До'); ?></span>
                <input name="price_to" value="<?= $price_to; ?>" class="products-filter__input" type="number">
            </label>
        </div>
    </div>
    <div class="products-filter__col">
        <p class="products-filter__label"><?php pll_e('Сортировка'); ?>:</p>
        <div class="products-filter-dropdown">
            <div class="products-filter-dropdown__current-wrap">
                <input name="sort" class="products-filter-dropdown__input" type="text" value="<?= $sort; ?>" readonly>
                <svg class="svg-sprite-icon icon-arrow products-filter-dropdown__icon">
                    <use xlink:href="<?= __SVG__ . '#arrow'; ?>"></use>
                </svg>
            </div>
            <ul class="products-filter-dropdown__list">
                <li class="products-filter-dropdown__item"><?php pll_e('По алфавиту'); ?></li>
                <li class="products-filter-dropdown__item"><?php pll_e('В начале дешевые'); ?></li>
                <li class="products-filter-dropdown__item"><?php pll_e('В начале дорогие'); ?></li>
            </ul>
        </div>
    </div>
    <button type="submit" class="btn--fill products-filter__submit filtersApply"><?php pll_e('Поиск'); ?></button>
    <?php if (Helper::filters_act()) : global $wp; ?>
        <a href="<?= !empty(get_query_var('term')) ? get_term_link(get_query_var('term'), 'type') : get_permalink() ?>" type="button" class="products-filter__clear"></a>
    <?php endif; ?>
</form>