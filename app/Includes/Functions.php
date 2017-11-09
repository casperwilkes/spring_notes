<?php

/**
 * Purpose:
 *  Site specific loose functions
 * History:
 *  110417 - Lincoln: Created file
 */

/**
 * Gets and loads config files for the site
 * @param string $configToLoad Name of config file to load
 * @return array Array of config options
 */
function loadConfig($configToLoad) {
    // Main config array //
    $main_config = array();
    // Override config array //
    $override_config = array();
    // Path to main config //
    $main_path = CONFIG_DIR . DS . $configToLoad . '.php';
    // Path to override //
    $override_path = CONFIG_DIR . DS . ENV . DS . $configToLoad . '.php';

    // Check if main config exists and include it //
    if (file_exists($main_path)) {
        $main_config = include $main_path;
    }

    // Check if override exists and include it //
    if (file_exists($override_path)) {
        $override_config = include $override_path;
    }

    // Merge config arrays into 1 array //
    $config = array_merge($main_config, $override_config);

    return $config;
}

/**
 * Returns the visitors IP address when submitting media. Used to log IP into
 * the database.
 * @return string
 */
function getIP() {
    $ip_array = array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
    );
    //    $server = filter_input_array(INPUT_SERVER, $_SERVER);
    $server = $_SERVER;
    foreach ($ip_array as $key) {
        if (array_key_exists($key, $server) === true) {
            foreach (array_map('trim', explode(',', $server[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                } else {
                    return 'Could not obtain Real IP, IP Given: ' . $server[$key];
                }
            }
        }
    }
}

/**
 * Checks if a string is json
 * @param string $string String to test
 * @return bool
 */
function is_json($string) {
    if (is_string($string)) {
        json_decode($string);

        return (json_last_error() === JSON_ERROR_NONE);
    }

    return false;
}

/**
 * Gets the string value of unprintable characters
 * @param mixed $var The variable to get the string value of
 * @return string Either returns string reps of characters, or returns the original value if already a string
 */
function str_value($var) {
    if (is_null($var)) {
        $val = 'Null';
    } elseif (is_bool($var)) {
        $val = ($var) ? 'True' : 'False';
    } else {
        $val = $var;
    }

    return $val;
}

/**
 * Checks that an index key exists within an array and returns a value
 * @param array $array Array to check against
 * @param string $index Index to check for
 * @param string $default Default value to return if index is not set
 * @return mixed Returns value of index, or default value
 */
function indexGet($array, $index, $default = '') {
    return isset($array[$index]) ? $array[$index] : $default;
}

/**
 * Outputs a glyph span with the provided glyph to user
 *
 * Frequent: {text input: glyph represented}
 *  * **home**: home
 *  * **back**: arrow-left
 *  * **next**: arrow-right
 *  * **edit**: pencil
 *  * **delete**: trash
 *  * **admin**: wrench
 *  * **view**: eye-open
 *
 * @param string $type Type of glyph to display
 * @example `this is <?= glyph('example')?>`
 * @return string glyphicon span
 */
function glyph($type) {
    // Cast input to lower case //
    $t = strtolower($type);
    // Check the input //
    switch ($t) {
        case 'home' :
            $glyph = 'home';
            break;
        case 'back':
            $glyph = 'arrow-left';
            break;
        case 'next':
            $glyph = 'arrow-right';
            break;
        case 'edit':
            $glyph = 'pencil';
            break;
        case 'delete':
            $glyph = 'trash';
            break;
        case 'admin':
            $glyph = 'wrench';
            break;
        case 'view':
            $glyph = 'eye-open';
            break;
        default:
            $glyph = $t;
            break;
    }

    return "<span class = 'glyphicon glyphicon-{$glyph}'></span>";

}

/**
 * Alias's a url
 * @param Slim\Slim $app Slim Environment
 * @param string $url Original url to alias
 * @param string $alias The alias for the url
 */
function alias_url(Slim\Slim $app, $url, $alias) {
    $env = $app->environment();

    if ($env['PATH_INFO'] === $url) {
        $env['PATH_INFO'] = $alias;
    }
}
