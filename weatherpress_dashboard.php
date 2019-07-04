<?php
/*
Plugin Name: WeatherPress Dashboard
Plugin URI: https://github.com/WebAssembler/weatherpress-dashboard
Description: An API-driven weather widget for the dashboard
Version: 1.3
Author: Anthony Hartnell
Author URI: https://www.anthonyhartnell.co.uk/
Text Domain: wep
*/

// Load in requirements from vendor folder
if( file_exists( __DIR__ . '/vendor/autoload.php' ) ){
    require 'vendor/autoload.php';
}

// Load the Guzzle Library
use GuzzleHttp\Client;

// Enqueue styles for the custom widget
add_action( 'admin_enqueue_scripts', 'wep_enqueue_dashboard_widget_styles' );
function wep_enqueue_dashboard_widget_styles() {
    wp_enqueue_style( 'wep_admin_style', plugin_dir_url( __FILE__ ) . 'css/admin.css', false, '1.0.0' );
    wp_enqueue_style( 'wep_icons', plugin_dir_url( __FILE__ ) . 'icomoon/style.css', false, '1.0.0' );
    wp_enqueue_style( 'wep_font', 'https://fonts.googleapis.com/css?family=Rubik:300,400', false, '1.0.0' );
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action( 'wp_dashboard_setup', 'wep_add_dashboard_widgets' );
function wep_add_dashboard_widgets() {

    wp_add_dashboard_widget(
        'wep_weather_widget',
        'Weather Press Dashboard',
        'wep_render_dashboard_widget_contents'
    );

}

// Swap the api icon codes for the fonts loaded from Meteocons
function wep_get_class_from_icon( $icon_id ) {
    if( ! $icon_id ) return;
    $class = '';
    switch( $icon_id ) {
        case '01d':
            $class = 'sunny';
            break;
        case '01n':
            $class = 'moon';
            break;
        case '02d':
            $class = 'few-clouds';
            break;
        case '02n':
            $class = 'few-clouds-night';
            break;
        case '03d':
            $class = 'scattered-clouds';
            break;
        case '04d':
            $class = 'broken-clouds';
            break;
        case '09d':
        case '09n':
            $class = 'shower-rain';
            break;
        case '10d':
            $class = 'rain-sun';
            break;
        case '10n':
            $class = 'rain-night';
            break;
        case '11d':
        case '11n':
            $class = 'thunderstorm';
            break;
        case '13d':
        case '13n':
            $class = 'snow';
            break;
        case '50d':
        case '50n':
            $class = 'haze'; // haze/mist
            break;
    }

    return $class;
}

// Output the content into the widget
function wep_render_dashboard_widget_contents() {

    $client = new Client( array(
        'base_uri' => 'http://api.openweathermap.org/data/2.5/'
    ) );
    $response = $client->request('GET', 'weather', [
        'query' => [
            'q' => 'Bristol,uk',
            'units' => 'metric', // For units in celsius
            'APPID' => 'YOUR_API_KEY'
        ]
    ]);

    $payload = $response->getBody()->getContents();
    $weather_data = json_decode( $payload );
    
    // Output the weather name and icon
    if( ! empty( $weather_data->weather ) ) {

        echo sprintf('<h2>%s, UK</h2>', $weather_data->name); // City name
        echo '<div id="icon_wrapper">';

        $current = $weather_data->weather[0];
        //https://openweathermap.org/weather-conditions
        $icon_class = wep_get_class_from_icon( $current->icon );
        echo '<div class="icon ' . $icon_class . '"></div>';
        echo '<div class="meta">';
        echo sprintf('<h2>%d%s <span class="format">C</span></h2>', $weather_data->main->temp, '&#186;');
        echo sprintf('<h3>%s</h3>', $current->main);   // Current weather name
        echo sprintf('<h5>%s %s</h5>', date('l'), date('H:i', strtotime('+ 1 hour')));   // Current day and time
        echo '</div>';

    }
    
}
