<?php
/*
Plugin Name:  Develtio - Theme settings
Plugin URI:   https://develtio.com
Description:  Theme settings boilerplate by develtio.com
Version:      1.0.0
Author:       Develtio
Author URI:   https://develtio.com
License:      MIT License
*/

namespace Develtio\WP\ThemeSettings;

defined('ABSPATH') || exit;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (!class_exists(__NAMESPACE__ . '\\Settings')) {
    wp_die(wp_kses_post('Develtio - Theme settings is missing required composer dependencies.'));
}

(new Settings())->init();
