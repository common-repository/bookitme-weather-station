<?php

function current_page_url() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"])) {
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

// Use shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//SHORTCODE display booking weather station from www.bookitme.com
function bookitme_weather($atts, $content = null) {

    //empty $_REQUEST shortcode  bookitme.com getDay from z $_SERVER
    $getDayPos = strpos($_SERVER['REQUEST_URI'], '?getDay=');
    if ($getDayPos) {
        $inp_getday = "&getDay=" . substr($_SERVER['REQUEST_URI'], $getDayPos + 8, 10);
    }
    $optionData = get_option('bookitme_weather_options');
    if ($optionData['inp_api']) {
        $inp_api = $optionData['inp_api'];
    } else {
        $inp_api = 1;
    }
    if ($optionData['inp_mt']) {
        if ($optionData['inp_mt'] == '1')
            $inp_mt = 'metric';
        if ($optionData['inp_mt'] == '2')
            $inp_mt = 'english';
        if (!$inp_mt)
            $inp_mt = 'metric';
    } else {
        $inp_mt = 'metric';
    }
    if ($optionData['inp_bimg']) {
        $inp_bimg = "&bimg=" . $optionData['inp_bimg'];
    }
    if ($optionData['inp_bvid']) {
        $inp_bvid = "&bvid=" . $optionData['inp_bvid'];
    }
    if ($optionData['inp_lab']) {
        $inp_lab = "&lab=" . $optionData['inp_lab'];
        $inp_lab = str_replace(" ", "%20", $inp_lab);
    }

    $curlfull = current_page_url();
    $curlsub = substr($curlfull, 0, strpos($curlfull, '?'));
    if (!$curlsub) {
        $curlsub = $curlfull;
    }
    //Set URL next days temperature
    $curl = '&curl=' . $curlsub;
    $weather = file_get_contents("http://www.bookitme.com/weather/wtapi.php?mt=$inp_mt&jsonapi=0&api=$inp_api$inp_bimg$inp_lab$inp_bvid$curl$inp_getday");
    $weather_rep = str_replace(PHP_EOL, "", $weather);
    return $weather_rep;
}

add_shortcode('bookitme-weather', 'bookitme_weather');

function bookitme_weather_json($atts, $content = null) {
    $optionData = get_option('bookitme_weather_options');
    if ($optionData['inp_api']) {
        $inp_api = $optionData['inp_api'];
    } else {
        $inp_api = 1;
    }
    if ($optionData['inp_mt']) {
        if ($optionData['inp_mt'] == '1')
            $inp_mt = 'metric';
        if ($optionData['inp_mt'] == '2')
            $inp_mt = 'english';
        if (!$inp_mt)
            $inp_mt = 'metric';
    } else {
        $inp_api = 'metric';
    }
    if ($optionData['inp_bimg']) {
        $inp_bimg = "&bimg=" . $optionData['inp_bimg'];
    }

    $weather = file_get_contents("http://www.bookitme/weather/wtapi.php?mt=$inp_mt&jsonapi=1&api=$inp_api$inp_bimg$inp_lab");
    return $weather;
}

add_shortcode('bookitme-weather-json', 'bookitme_weather_json');

function bookitme_mobile_weather($atts, $content = null) {
    //empty $_REQUEST shortcode  bookitme.com getDay from z $_SERVER
    $getDayPos = strpos($_SERVER['REQUEST_URI'], '?getDay=');
    if ($getDayPos) {
        $inp_getday = "&getDay=" . substr($_SERVER['REQUEST_URI'], $getDayPos + 8, 10);
    }
    $optionData = get_option('bookitme_weather_options');
    if ($optionData['inp_api']) {
        $inp_api = $optionData['inp_api'];
    } else {
        $inp_api = 1;
    }
    if ($optionData['inp_mt']) {
        if ($optionData['inp_mt'] == '1')
            $inp_mt = 'metric';
        if ($optionData['inp_mt'] == '2')
            $inp_mt = 'english';
        if (!$inp_mt)
            $inp_mt = 'metric';
    } else {
        $inp_mt = 'metric';
    }
    if ($optionData['inp_bcolor']) {
        if (strpos($optionData['inp_bcolor'], "#") === 0) {
            $optionData['inp_bcolor'] = substr($optionData['inp_bcolor'], 1);
        }
        $inp_bcolor = "&bcolor=" . $optionData['inp_bcolor'];
    }

    if ($optionData['inp_lab']) {
        $inp_lab = "&lab=" . $optionData['inp_lab'];
        $inp_lab = str_replace(" ", "%20", $inp_lab);
    }
    $curlfull = current_page_url();
    $curlsub = substr($curlfull, 0, strpos($curlfull, '?'));
    if (!$curlsub) {
        $curlsub = $curlfull;
    }
    //Set URL next days temperature
    $curl = '&curl=' . $curlsub;
    $weather = file_get_contents("http://www.bookitme.com/weather/wtapi.php?fout=2&mt=$inp_mt&jsonapi=0&api=$inp_api$inp_bimg$inp_lab$inp_bvid$curl$inp_getday$inp_bcolor");
    $weather_rep = str_replace(PHP_EOL, "", $weather);
    return $weather_rep;
}
add_shortcode('bookitme-mobile-weather', 'bookitme_mobile_weather');
?>