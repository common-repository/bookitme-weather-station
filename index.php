<?php
/**
 * Plugin Name: Bookitme Weather Station
 * Plugin URI: http://www.bookitme.com/weather/
 * Description: Hourlly Weather Forecast with easy interface to include shortcode for display weather forecast from bookitme.com weather station
 * Version: 1.0.3
 * Author: Anthony Gate
 * Author URI: http://www.bookitme.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */
// Plugin Directory 
define('BOOKITME_DIR', dirname(__FILE__));

register_activation_hook(__FILE__,'register_bookitme_weather_template');
register_deactivation_hook(__FILE__,'deregister_bookitme_weather_template');

function register_bookitme_weather_template() {
    $template_destination =get_bookitme_weather_destination();
    $template_source = get_bookitme_weather_source();
    //copy_page_bookitme_weather($template_source, $template_destination);
}

function deregister_bookitme_weather_template() {
    $theme_dir = get_template_directory();
    $template_path = $theme_dir . '/page-bookitme-weather.php';
    if (file_exists($template_path)) {
        unlink($template_path);
    }
}

function get_bookitme_weather_destination() {
    return get_template_directory() . '/page-bookitme-weather.php';
}

function get_bookitme_weather_source() {
    return dirname(__FILE__) . '/lib/templates/page-bookitme-weather.php';
}

function copy_page_bookitme_weather($template_source, $template_destination) {
    if (!file_exists($template_destination)) {
        touch($template_destination);
        if (null != ( $template_handle = @fopen($template_source, 'r') )) {
            if (null != ( $template_content = fread($template_handle, filesize($template_source)) )) {
                fclose($template_handle);
            }
        }
        if (null != ( $template_handle = @fopen($template_destination, 'r+') )) {
            if (null != fwrite($template_handle, $template_content, strlen($template_content))) {
                fclose($template_handle);
            }
        }
    }
}

//Admin Option
include_once( BOOKITME_DIR . '/lib/functions/admin.php' );
// Shortcodes
include_once( BOOKITME_DIR . '/lib/functions/shortcodes.php' );
?>
