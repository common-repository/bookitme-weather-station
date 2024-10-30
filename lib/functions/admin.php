<?php

class BookitmeWeather {

    function __construct() {
        //$this->setDefaultValues();
        $this->options = get_option('bookitme_weather_options');

        if ($_POST['inp_api']) {
            $lov['inp_api'] = intval($_POST['inp_api']);
        } else {
            $lov['inp_api'] = $this->options['inp_api'];
        }

        if ($_POST['inp_mt']) {
            $lov['inp_mt'] = intval($_POST['inp_mt']);
        } else {
            $lov['inp_mt'] = $this->options['inp_mt'];
        }

        if ($_POST['inp_lng']) {
            $lov['inp_lng'] = htmlspecialchars($_POST['inp_lng']);
        } else {
            $lov['inp_lng'] = $this->options['inp_lng'];
        }
        if ($_POST['inp_bimg']) {
            $lov['inp_bimg'] = htmlspecialchars($_POST['inp_bimg']);
        } else {
            $lov['inp_bimg'] = $this->options['inp_bimg'];
        }
        if ($_POST['inp_bvid']) {
            $lov['inp_bvid'] = htmlspecialchars($_POST['inp_bvid']);
        } else {
            $lov['inp_bvid'] = $this->options['inp_bvid'];
        }
        if ($_POST['inp_lab']) {
            $lov['inp_lab'] = htmlspecialchars($_POST['inp_lab']);
        } else {
            $lov['inp_lab'] = $this->options['inp_lab'];
        }
        if ($_POST['inp_bcolor']) {
            $lov['inp_bcolor'] = htmlspecialchars($_POST['inp_bcolor']);
        } else {
            $lov['inp_bcolor'] = $this->options['inp_bcolor'];
        }


        $this->updateParams($lov);
        $this->options = get_option('bookitme_weather_options');
        add_action('admin_menu', array(&$this, 'bookitmeAdminMenu'));
    }

    function updateParams($lov) {
        update_option('bookitme_weather_options', $lov);
    }

    function bookitmeAdminMenu() {
        //create a sub admin panel link above
        add_menu_page('Bookitme weather station', 'Weather', 'administrator', 8, array(&$this, 'overview'));
        add_submenu_page(8, 'Settings', 'Settings', 'administrator', 1, array(&$this, 'bookitmeRenderForm'));
    }

    function overview() {
        $imgPath = plugins_url() . '/bookitme-weather/lib/images';

        echo "<a style=\"text-decoration:none;\" href=\"http://www.bookitme.com\"><div style=\"background-color:black;padding:20px;\"><img src=\"http://www.bookitme.com/wp-content/uploads/2011/10/logo52.png\">
        <span style=\"font-size:50px;color:#ffffff;padding-left:20px;\">weather station</span></div></a>";
        echo $out = "<div style=\"font-size:15px;\">
<p><strong>Bookitme weather station</strong> bring to wordpress the most easy way how include hourly weather data directly into Wordpress page and wordpress widgets.</p> 
<p><strong>Bookitme weather station</strong> provides weather forecast data totally free.</p> 
You need only ask us for weather API. 
<p><strong>Sent email to <a href=\"mailto:weather@bookitme.com\">weather@bookitme.com</a> with your LONGTITUDE and LATITUDE.</strong></p>
We will generate your API in few minutes.<br> 
After activation Wordpress plugin <strong>BOOKITME Weather station</strong> you fill input text field <strong>API</strong> and you can display forecast data directly into your page or widget.<br>
You can set METRIC or ENGLISH output format and your cusotm background image for your weather forecast. 
<p>Two shortcodes operate in the BOOKITME Weather station plugin</p>
<p><strong>SHORTCODES:</strong></p>
<strong>[bookitme-weather]</strong><br>
This short code show Actual Weather Data and hourly data into nice use friendly form.<br>
<strong>[bookitme-weather-json]</strong><br>
This shortcode give you change prepare your own weather look with data from actual weather data.    
<img src=\"$imgPath/ex7.jpg\" />            
</div>";
    }

    function setDefaultValues() {
        if ($this->options['inp_api'] == 0) {
            $setVal['inp_api'] = '1';
        } else {
            $setVal['inp_api'] = $this->options['inp_api'];
        }
        $this->updateParams($setVal);
    }

    function bookitmeRenderForm() {
        $form = "
<style type=\"text/css\">
.bt {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#1b6e87;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:1px 1px 0px #ffffff;
}.bt:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.bt:active {
	position:relative;
	top:1px;
}    
</style>
<a style=\"text-decoration:none;\" href=\"http://www.bookitme.com\"><div style=\"background-color:black;padding:20px;\"><img src=\"http://www.bookitme.com/wp-content/uploads/2011/10/logo52.png\">
<span style=\"font-size:50px;color:#ffffff;padding-left:20px;\">weather station</span></div></a>";

        $form .= "<div style=\"wifth:80%;text-align:left;  \">";
        $form .= '
        <form method="post" action="' . $_SERVER["REQUEST_URI"] . '">
            <table class="form-table">
                <tr valign="top">
                <tr><td colspan="2"><div style="margin-top:10px;"><h1>WEATHER STATION default values:</h1></div></td></tr>
                <th scope="row"><strong>API number :</strong></th>
                <td><input type="text" name="inp_api" value="' . $this->options['inp_api'] . '" /><span style="font-style:italic;padding:10px;">default : 1</span></td>
                <tr><td scope="row"><strong>METRIC system :</strong></td>
                <td><input type="text" name="inp_mt" value="' . $this->options['inp_mt'] . '" /><span style="font-style:italic;padding:10px;">default : metric:1 / english:2</span></td>
                <tr><td scope="row"><strong>LANGUAGE :</strong></td>
                <td><input type="text" name="inp_lng" value="' . $this->options['inp_lng'] . '" /><span style="font-style:italic;padding:10px;">default : ENG</span></td></tr>
                <tr><td scope="row"><strong>Background Image :</strong></td>
                <td><input type="text" style="width:500px;" name="inp_bimg" value="' . $this->options['inp_bimg'] . '" /><span style="font-style:italic;padding:10px;">default : URL for weather background image</span></td></tr>         
                <tr><td scope="row"><strong>Background Video :</strong></td>
                <td><input type="text" style="width:500px;" name="inp_bvid" value="' . $this->options['inp_bvid'] . '" /><span style="font-style:italic;padding:10px;">default : URL for weather background video</span></td></tr>                         
                <tr><td scope="row"><strong>CITY LABEL :</strong></td>
                <td><input type="text" name="inp_lab" value="' . $this->options['inp_lab'] . '" /><span style="font-style:italic;padding:10px;">default : null Label for weather station</span></td></tr>
                    <tr><td scope="row"><strong>MOBILE BACKGROUND COLOR :</strong></td>
                <td><input type="text" name="inp_bcolor" value="' . $this->options['inp_bcolor'] . '" /><span style="font-style:italic;padding:10px;">default : #66B8FF Mobile weather station background color</span></td></tr>
             </table>  
             <div style="padding-top:20px;width:460px;text-align:right;"><input type="submit" class="bt" name="update_bookitme_options" value="submit" /></div>
        </form></div>
        ';

        echo $form;
    }

}

$mybackuper = &new BookitmeWeather();
?>