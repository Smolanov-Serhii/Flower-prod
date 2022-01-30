<?php
if (!class_exists('Assets_init')) {
    class Assets_init
    {
        use Singleton;
    
        public static function register()
        {
            $instance = self::get_instance();

            add_action('wp_enqueue_scripts', [$instance, 'init']);
            add_action('admin_enqueue_scripts', [$instance, 'admin_assets']);
        }

        public function init()
        {

            // JS
            $main_js = __DIST_PATH__ . 'main.js';
            $main_js_uri = __DIST_URI__.'main.js';
            file_exists($main_js) && wp_enqueue_script('main-js', $main_js_uri, array(), filemtime($main_js), true);
            
            // CSS
            $main_css = __DIST_PATH__ . 'main.css';
            $main_css_uri = __DIST_URI__.'main.css';
            file_exists($main_css) && wp_enqueue_style('main', $main_css_uri, filemtime($main_css));
        }

        public function admin_assets()
        {

            $scripts = [
                'theme_options' => THEME_URL . '/admin/js/theme_options.js',
            ];

            wp_enqueue_script('theme_options', $scripts['theme_options'], [], true);


            $styles = [
                'theme_options' => THEME_URL . '/admin/css/theme_options.css',
                // 'services_metabox' => THEME_URL . '/admin/css/services_metabox.css'
            ];

            // wp_enqueue_style('services_metabox', $styles['services_metabox']);
            wp_enqueue_style('theme_options', $styles['theme_options'], '', '5.7');
        }
    }
}
