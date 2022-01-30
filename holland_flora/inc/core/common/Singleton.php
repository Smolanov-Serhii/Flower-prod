<?php

if (! trait_exists('Singleton')) {
    trait Singleton
    {
        private static $instance = null;

        private function __construct()
        {
        }

        private function __clone()
        {
        }

        private function __wakeup()
        {
        }

        public static function get_instance()
        {
            return (self::$instance === null) ? self::$instance = new static() : self::$instance;
        }
    }
}
