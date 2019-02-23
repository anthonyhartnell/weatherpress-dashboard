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
    echo '<h4>Weather data here</h4>';
}
