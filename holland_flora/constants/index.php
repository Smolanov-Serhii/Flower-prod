<?php
// GENERAL
define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('ADMIN_AJAX', admin_url('admin-ajax.php'));
define('TEXTDOMAIN', 'holland_flora');

// ASSETS
define('__SVG__', THEME_URL . '/dist/images/sprite/sprite.svg');
define('__IMAGES_DIR__', THEME_URL . '/dist/images/');
define('__DIST_PATH__', THEME_DIR . '/dist/');
define('__DIST_URI__', THEME_URL . '/dist/');

// MENUS
define('HEADER_MENU', 'header-menu');
define('FOOTER_MENU', 'footer-menu');

// CUSTOM FIELDS
define('FAQ_LIMIT', 10);
define('ORDER_TIME_LIMIT', 6);
define('SERVICE_FEATURE_LIMIT', 6);
define('BLOG_PER_PAGE', 9);
define('PRODUCTS_PER_PAGE', 24);