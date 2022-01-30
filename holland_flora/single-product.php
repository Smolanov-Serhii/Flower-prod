<?php
/**
 *
 * Template Name: Страница Продукта
 * Template Post Type: product
 * @description Не используется — нету деталки продукта!
 */


global $post;
$min_count = get_field('product-minimum-quantity-to-order', $post->ID);
$color = get_field('product-color', $post->ID);
$height = get_field('product-height', $post->ID);
$price = get_field('product-price', $post->ID);
$code = get_post_meta($post->ID, 'code', true);
$img = get_the_post_thumbnail_url($post->ID);
$gallery =  get_post_galleries_images($post->ID);
$payment = get_field("product-payment");
$shiping = get_field("shiping");
$seotext = get_field("seo-block", $post->ID);
get_header();
View::render_breadcrumbs($shop = true);

global $product;

$attachment_ids = $product->get_gallery_image_ids();


/* echo "<pre>";
print_r($product);
echo "</pre>";
 */
/* current Tegs */

$shippingClass = $product->get_shipping_class();
$shipp_classname = get_term_by('slug',$shippingClass ,'product_shipping_class');


/* current Tegs */

$terms = get_the_terms( $post->ID, 'product_tag' );
$idterm = $terms["0"]->term_id;

?>

<div class="single__product">
        <div class="single__top">
            <div class="container">
                <div class="single__top-container ">
                    <div class="single__top-left">
                        <?php
                        if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
                            return;
                        }

                        $columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
                        $post_thumbnail_id = $product->get_image_id();
                        $wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
                            'woocommerce-product-gallery',
                            'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
                            'woocommerce-product-gallery--columns-' . absint( $columns ),
                            'images'
                        ) );
                        ?>
                        <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 1;">
                            <figure class="woocommerce-product-gallery__wrapper">
                                <?php
                                if ( $product->get_image_id() ) {
                                    $html = wc_get_gallery_image_html( $post_thumbnail_id, true );
                                } else {
                                    $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                    $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Загрузка картинки', 'woocommerce' ) );
                                    $html .= '</div>';
                                }

                                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

                                do_action( 'woocommerce_product_thumbnails' );

                                ?>
                            </figure>
                        </div>

                    </div>
                   <div class="single__top-right productItem">
                        <div class="product__code">
                        <?php pll_e('Код товара'); ?>: <?php echo $code?>
                        </div>
                        <h2 class="product__title">
                        <?= $post->post_title; ?>
                        </h2>
                        <div class="product__data">
                            <div class="product__data-line">
                                <span><?php pll_e('Мин. кол-во'); ?>:</span>
                                <span></span>
                                <span ><?php echo $min_count; ?>шт.</span>
                            </div>
                            <div class="product__data-line">
                                <span><?php pll_e('Цвет'); ?>:</span>
                                <span></span>
                                <span><?php echo $color; ?></span>
                            </div>
                            <div class="product__data-line">
                                <span><?php pll_e('Высота'); ?>:</span>
                                <span></span>
                                <span><?php echo $height; ?></span>
                            </div>
                        </div>
                        <div class="product__current-price">
                            <span class="currentPrice"><?= Helper::get_price_grn($price); ?></span>
                            <?php pll_e('грн./шт.'); ?>
                            <span class="block__full-amount"><span class="countPrice"><?= Helper::get_price_grn($price*$min_count); ?></span> <?php pll_e('грн./лот.'); ?></span>

                        </div>
                        <div class="signle__product-order">
                            <div class="counter counterMinVal" data-min-value="<?= $min_count; ?>">
                                <button class="counter__btn changeCountBtn" type="button" data-counter-trigger="minus"></button>
                                <input class="counter__input itemsCount" type="number" value="<?= $min_count; ?>" readonly>
                                <button class="counter__btn changeCountBtn" type="button" data-counter-trigger="plus"></button>
                            </div>
                            <?php View::render_add_to_cart_form($post->ID, $min_count); ?>
                        </div>
                        <div class="single__product-info">
                                <div class="single__product-tabs-nav">
                                    <a href="" class="tabs__nav-item active">Описание</a>
                                    <a href="" class="tabs__nav-item">Доставка</a>
                                    <a href="" class="tabs__nav-item">Оплата</a>
                                </div>
                                <div class="single__product-tab active">
                                 <?php the_content(); ?>
                                </div>
                                <div class="single__product-tab">

                                <?php
                                echo $shiping;

                                ?>
                                </div>
                                <div class="single__product-tab">
                                 <?php echo $payment; ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!--    <div class="single__product-same">-->
<!--        <div class="container">-->
<!--        <div class="product__same-title">-->
<!--            <h3>Похожие товары</h3>-->
<!--        </div>-->
<!--            <div class="product__same-container">-->
<!--                 <div class="products-inside__list productsList">-->
<!--                   --><?php
//                   // get the custom post type's taxonomy terms
//                   $related_tag = wp_get_object_terms( $post->ID, 'product_tag', array('fields' => 'ids'));
//                   $related_cat = wp_get_object_terms( $post->ID, 'product_cat', array('fields' => 'ids'));
//
//                   // arguments 1
//                   $args1 = array(
//                     'post_type' => 'product',
//                     'post_status' => 'publish',
//                     'posts_per_page' => 5,
//                     'orderby' => 'rand',
//                     'meta_query' => array(
//                       array(
//                         'key' => 'product-price',
//                         'value' => 0,
//                         'compare' => '>',
//                         'type' => 'NUMERIC',
//                       ),
//                     ),
//
//                     'tax_query' => array(
//
//                       array(
//
//                         'taxonomy'     => 'product_tag',
//                         'field'        => 'id',
//                         'terms'        =>  $related_tag,
//                       ),
//
//                     ),
//                     'post__not_in' => array ($post->ID),
//                   );
//                   // arguments 2
//                   $args2 = array(
//                     'post_type' => 'product',
//                     'post_status' => 'publish',
//                     'posts_per_page' => 5,
//                     'orderby' => 'rand',
//                     'meta_query' => array(
//                       array(
//                         'key' => 'product-price',
//                         'value' => 0,
//                         'compare' => '>',
//                         'type' => 'NUMERIC',
//                       ),
//                     ),
//                     'tax_query' => array(
//
//                       array(
//
//                         'taxonomy'     => 'product_cat',
//                         'field'        => 'id',
//                         'terms'        =>  $related_cat,
//                       ),
//
//                     ),
//                     'post__not_in' => array ($post->ID),
//
//                   );
//
//                   $related_items1 = new WP_Query( $args1 );
//                   $related_items2 = new WP_Query( $args2 );
//                   $related_items = new WP_Query();
//                   $related_items->posts = array_merge( $related_items1->posts, $related_items2->posts );
//
//                   $related_items3->post_count=40 - $related_items1->post_count;
//
//                   $related_items->post_count = $related_items2->post_count + $related_items3->post_count;
//
//
//                   // loop over query
//                   $counter=0;
//                   if ($related_items->have_posts()) :
//                     while ( $related_items->have_posts() ) : $related_items->the_post();
//                       if($counter == 5){
//                         break;
//                       }
//                       get_template_part('template-parts/product-card');
//                     endwhile;
//                   endif;
//                   // Reset Post Data
//                   wp_reset_postdata();
//                   ?>
<!---->
<!---->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="single__product-footer">
        <div class="container">
            <div class="single__product-footer-text">
             <?php echo $seotext; ?>
            </div>
        </div>
    </div>
</div>

<?php get_template_part('template-parts/popups/product-single'); ?>
    <?php get_template_part('template-parts/popups/add_to_cart/info'); ?>



<?php get_footer(); ?>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<script>
$(function() {


  $('.single__product-tabs-nav').on('click', '.tabs__nav-item:not(.active)', function(e) {
      e.preventDefault();
    $(this)
      .addClass('active').siblings().removeClass('active')
      .closest('.single__product-info').find('.single__product-tab').removeClass('active').eq($(this).index()).addClass('active');
  });

});
</script>
