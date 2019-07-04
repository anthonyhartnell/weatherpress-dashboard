![weatherpress dashboard logo](https://raw.githubusercontent.com/WebAssembler/weatherpress-dashboard/master/weatherpress_dashboard.jpg)

# WeatherPress Dashboard
A simple plugin to add an API-drive weather widget in the WordPress Dashboard. It uses the Guzzle HTTP client to fetch an API endpoint and formats the result inside a custom widget.

## Installation
1. Register for an API key at https://openweathermap.org/api
1. Download and install the plugin into `wp-content/plugins`  directory
1. Run `composer install` inside the plugin folder. This will download and install the dependencies inside `composer.json`
1. Enter your API Key from Open Weather Map and put it in the `APPID` section where it says `'APPID' => 'YOUR_API_KEY'`
1. Change the city to your preferred city in the `q` parameter - currently set to `'q' => 'Bristol,uk',`

## Credits
*  The weather icons are designed by Alessio Atzeni and made freely at http://www.alessioatzeni.com/meteocons/
*  Icons converted using IcoMoon
