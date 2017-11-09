<?php
/**
 * Purpose:
 *  Defines all the site constants
 * History:
 *  110417 - Lincoln: Created file
 */

namespace Spring_App\Includes;

// Manual Environment //
$env = 'dev';

// Site Definitions //
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
// Site root //
defined('SITE_ROOT') ? null : define('SITE_ROOT', dirname(dirname(__DIR__)));
// App directory //
defined('APP_ROOT') ? null : define('APP_ROOT', SITE_ROOT . DS . 'app');
// Log directory //
defined('LOGS_DIR') ? null : define('LOGS_DIR', SITE_ROOT . DS . 'logs');
// Template directory //
defined('TPL_DIR') ? null : define('TPL_DIR', APP_ROOT . DS . 'Views');
// Config directory //
defined('CONFIG_DIR') ? null : define('CONFIG_DIR', APP_ROOT . DS . 'Config');
// Routes //
defined('ROUTES') ? null : define('ROUTES', APP_ROOT . DS . 'Route');

// Environment //
defined('ENV') ? null : define('ENV', $_SERVER['ENV'] !== null ? $_SERVER['ENV'] : $env);
// Test environment //
defined('TEST') ? null : define('TEST', ENV === 'dev');