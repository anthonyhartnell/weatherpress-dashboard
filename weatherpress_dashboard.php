<?php
/*
Plugin Name: WeatherPress Dashboard
Plugin URI: https://github.com/WebAssembler/weatherpress-dashboard
Description: An API-driven weather widget for the dashboard
Version: 1.0
Author: Anthony Hartnell
Author URI: https://www.atomicsmash.co.uk/
Text Domain: wep
*/

// Load in requirements from vendor folder
if( file_exists( __DIR__ . '/vendor/autoload.php' ) ){
    require 'vendor/autoload.php';
}

// Load the Guzzle Library
use GuzzleHttp\Client;


// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action( 'wp_dashboard_setup', 'wep_add_dashboard_widgets' );
function wep_add_dashboard_widgets() {

    wp_add_dashboard_widget(
        'wep_weather_widget',
        'Weather Press Dashboard',
        'wep_render_dashboard_widget_contents'
    );

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

    echo sprintf('<h2>%s, UK</h2>', $weather_data->name); // City name
    echo sprintf('<h3>%s %s</h3>', date('l'), date('h:00'));   // Current day and time

    // Output the weather name and icon
    if( ! empty( $weather_data->weather ) ) {

        $current = $weather_data->weather[0];
        echo sprintf('<h3>%s</h3>', $current->main);   // Current weather name

        // Format and output the icon
        $icon_url = 'http://openweathermap.org/img/w/' . $current->icon . '.png';
        echo sprintf('<img src="%s" width="%dpx">', $icon_url, 100);

    }

    // Output the temperature
    echo sprintf('<h1>%d %s C</h1>', $weather_data->main->temp, '&#186;');

}


