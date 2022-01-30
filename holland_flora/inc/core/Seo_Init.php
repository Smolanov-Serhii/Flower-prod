<?php

if (!class_exists('SEO_Init')) {
    class SEO_Init
    {
        use Singleton;

        public static function register()
        {
            $instance = self::get_instance();

            add_action('wp_head', [$instance, 'favicon_init']);

            add_filter('script_loader_src', [$instance, 'crunchify_cleanup_query_string'], 15, 1);
            add_filter('style_loader_src', [$instance, 'crunchify_cleanup_query_string'], 15, 1);

            remove_action('wp_head', 'wp_oembed_add_discovery_links');
            remove_action('wp_head', 'wp_oembed_add_host_js');
            remove_action('wp_head', [$instance, 'print_emoji_detection_script'], 7);
            remove_action('wp_print_styles', 'print_emoji_styles');

            remove_action('wp_head', [$instance, 'rest_output_link_wp_head'], 10);
            remove_action('wp_head', [$instance, 'wp_oembed_add_discovery_links'], 10);
            remove_action('template_redirect', [$instance, 'rest_output_link_header'], 11, 0);
 
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'wp_shortlink_wp_head');
        }

        public function favicon_init()
        {
            ob_start();
            require_once THEME_DIR.'/template-parts/meta/favicon.php';
            echo ob_get_clean();
        }

        public function crunchify_cleanup_query_string($src)
        {
            $parts = explode('?', $src);
            return $parts[0];
        }
    }
}
