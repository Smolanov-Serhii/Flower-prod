<?php
// session_save_path('/tmp');
session_start();

require_once 'constants/index.php';
require_once 'constants/theme_option.php';

spl_autoload_register(function ($class) {
    $array_dirs = ['core', 'core/common', 'handlers', 'helpers', 'custom-type'];

    foreach ($array_dirs as $dir) {
        if (file_exists(TEMPLATEPATH . '/inc/' . $dir . '/' . $class . '.php')) {
            require_once TEMPLATEPATH . '/inc/' . $dir . '/' . $class . '.php';
            break;
        }
    }
});

$dirs = ['core', 'handlers', 'custom-type'];
foreach ($dirs as $dir) {
    $files = glob(TEMPLATEPATH . '/inc/' . $dir . '/*.php');

    foreach ($files as $path) {
        $info = pathinfo($path);
        $info['filename']::register();
    }
}

if (!function_exists('dd')) {
    function dd($data)
    {
        exit(var_dump($data));
    }
}

if (!function_exists('tax_permalink')) {
    function tax_permalink($params = '')
    {
        global $wp_query;
        $tax = $wp_query->get_queried_object();

        return site_url("/{$tax->taxonomy}/{$tax->slug}/$params");
    }
}


// TEMP
add_action('admin_init', 'redirect_non_admin_users');
/**
 * Redirect non-admin users to home page
 *
 * This function is attached to the ‘admin_init’ action hook.
 */
function redirect_non_admin_users()
{
    if (!current_user_can('manage_options') && ('/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'])) {
        wp_redirect(home_url());
        exit;
    }
}


if (!current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}


if (!function_exists('get_page_url_by_template_name')) {
    function get_page_url_by_template_name($template_name)
    {
        $pages = query_posts(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => "{$template_name}.php"
        ));

        $url = null;
        if (isset($pages[0])) {
            $url = get_page_link($pages[0]->ID);
        }
        return $url;
    }
}


add_filter('pll_get_post_types', 'add_cpt_to_pll', 10, 2);

function add_cpt_to_pll($post_types, $is_settings)
{
    if ($is_settings) {
        // hides 'my_cpt' from the list of custom post types in Polylang settings
        unset($post_types['my_cpt']);
    } else {
        // enables language and translation management for 'my_cpt'
        $post_types[Benefit_CPT::NAME] = Benefit_CPT::NAME;
        $post_types[Review_CPT::NAME] = Review_CPT::NAME;
    }
    return $post_types;
}


/*
 * Отключение стандартных CSS в HTML-коде
 */
function my_filter_head()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}

add_action('get_header', 'my_filter_head');

/*
 * CSS для прилепления админки к нижнему краю страницы
 */
function true_move_admin_bar()
{
    echo '
	<style type="text/css">
	html{margin-bottom:32px !important}
	* html body{margin-bottom:32px !important}
	#wpadminbar{top:auto !important;bottom:0}
	#wpadminbar .menupop .ab-sub-wrapper{bottom:32px;-moz-box-shadow:2px -2px 5px rgba(0,0,0,.2);-webkit-box-shadow:2px -2px 5px rgba(0,0,0,.2);box-shadow:2px -2px 5px rgba(0,0,0,.2)}
	@media screen and ( max-width:782px ){
		html{margin-bottom:46px !important}
		* html body{margin-bottom:46px !important}
		#wpadminbar{position:fixed}
		#wpadminbar .menupop .ab-sub-wrapper{bottom:46px}
	}
	</style>
	';
}

//add_action( 'admin_head', 'true_move_admin_bar' ); // в админке
add_action('wp_head', 'true_move_admin_bar'); // на сайте

## Удаляет "Рубрика: ", "Метка: " и т.д. из заголовка архива
add_filter('get_the_archive_title', function ($title) {
    return strip_tags(preg_replace('~^[^:]+: ~', '', $title));
});

add_filter('show_admin_bar', '__return_false');


add_action('template_redirect', 'action_function_name_5864');
function action_function_name_5864()
{
    $uri = $_SERVER['REQUEST_URI'];
    if (isset($_SESSION) && strpos($uri, '/basket/') === false && strpos($uri, '/type/') !== false) {
        $_SESSION['redirect_uri'] = $uri;
    }
}
add_theme_support( 'wc-product-gallery-slider' );


function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );


/* add_filter( 'get_pagenum_link', 'wpse_78546_pagenum_link' );

function wpse_78546_pagenum_link( $link )
{
    return preg_replace( '~/page/(\d+)/?~', '/?paged=\1', $link );
} */


//New "Related Products" function for WooCommerce
function get_related_custom( $id, $limit = 5 ) {
  global $woocommerce;

// Related products are found from category and tag
  $tags_array = array(0);
  $cats_array = array(0);

// Get tags
  /*
  $terms = wp_get_post_terms($id, 'product_tag');
  foreach ( $terms as $term ) $tags_array[] = $term->term_id;
  */
// Get categories (removed by NerdyMind)

  $terms = wp_get_post_terms($id, 'product_cat');
  foreach ( $terms as $term ) $cats_array[] = $term->term_id;
// Don't bother if none are set
  if ( sizeof($cats_array)==1 && sizeof($tags_array)==1 ) return array();

// Meta query
  $meta_query = array();
  $meta_query[] = $woocommerce->query->visibility_meta_query();
  $meta_query[] = $woocommerce->query->stock_status_meta_query();

// Get the posts
  $related_posts = get_posts( apply_filters('woocommerce_product_related_posts', array(
    'orderby' => 'rand',
    'posts_per_page' => $limit,
    'post_type' => 'product',
    'fields' => 'ids',
    'meta_query' => $meta_query,
    'tax_query' => array(
      'relation' => 'OR',
      array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => $cats_array
      ),
      array(
        'taxonomy' => 'product_tag',
        'field' => 'id',
        'terms' => $tags_array
      )
    )
  ) ) );
  $related_posts = array_diff( $related_posts, array( $id ));
  return $related_posts;
}
add_action('init','get_related_custom');

add_filter('pre_site_transient_update_core',create_function('$a', "return null;"));
wp_clear_scheduled_hook('wp_version_check');

remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
wp_clear_scheduled_hook( 'wp_update_plugins' );

