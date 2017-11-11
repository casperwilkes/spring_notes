<?php

/**
 * Purpose:
 *  Load application and run it
 * History:
 *  110517 - Lincoln: Created file
 *  111117 - #3 - Lincoln: Added a route alias for the API
 */

//
// Require the site autoloader //
require '../vendor/autoload.php';

use Spring_App\Utility;
use Spring_App\Model;

// In order to stop slim from overwriting the session,
// we need to set it here //
session_cache_limiter(false);
session_start();

// Init App //
$app = new Slim\Slim();

// Load appropriate config files //
$app->config(loadConfig('slim'));

// Setup logging object //
$log = new Utility\Logger\Log();

// Setup the session //
$session = new Utility\Session();

// Setup session messages handler //
$messenger = new Utility\Messenger();

// Setup logged in user //
$user = new Model\User($session);

// Navigation data //
$navigation = new Utility\Navigation($app->request->getPathInfo(), $user->checkLogin());

// Dynamically load controllers //
$di = new DirectoryIterator(APP_ROOT . DS . 'Controller');

// Set a full path variable //
$app->environment['FULL_PATH'] = $app->request->getUrl() . $app->request->getRootUri();

// Require the controllers //
foreach ($di as $file) {
    if (!$file->isDot() && !$file->isDir()) {
        require $file->getPathname();
    }
}

// Used for assets/urlFor method for absolute paths//
$app->hook('slim.before', function () use ($app, $navigation, $messenger) {
    // Set the applications base template //
    $app->view->setBase('template');

    // Add data to the view //
    $app->view->replace(
        array(
            // Set base url for site //
            // current domain based on environment//
            'baseUrl' => $app->environment['FULL_PATH'],
            // Setup navigation bar //
            'navigation' => $navigation,
            // Setup session messages //
            'messenger' => $messenger,
        ));

    // Url alias's //
    alias_url($app, '/login', '/users/login');
    alias_url($app, '/logout', '/users/logout');
    alias_url($app, '/register', '/users/register');
    alias_url($app, '/api', '/v1');
});

// Api token authorization //
$app->hook('slim.before.dispatch', function () use ($app) {
    // Need to validate api tokens //
    if (stripos($app->request->getResourceUri(), '/v1/') !== false) {
        // Api tokens //
        $tokens = loadConfig('api_tokens');
        // App tokens //
        $incoming = $app->request->get();

        // Validation body //
        $validate = array(
            'validated' => false,
            'key' => '',
            'token' => '',
            'message' => '',
        );

        // Check that we have incoming tokens and keys //
        if (array_key_exists('token', $incoming) && array_key_exists('key', $incoming)) {
            // Set them for the validation body //
            $validate['key'] = $incoming['token'];
            $validate['token'] = $incoming['key'];

            // Check the tokens against ours //
            if ($tokens['token'] === $incoming['token'] && $tokens['key'] === $incoming['key']) {
                $validate['validated'] = true;
            } else {
                $validate['message'] = 'Incorrect key or token to access api';
            }
        } else {
            $validate['message'] = 'Application Key and Token required to access api';
        }

        // Did not validate, return an error //
        if (!$validate['validated']) {
            // Set the status & headers //
            $app->response->status(401);
            $app->response->headers->set('Content-Type', 'application/json');

            // Build a body and encode it //
            $body = array(
                'results' => '',
                'error' => $validate,
            );

            $message = json_encode($body);

            // Return for user //
            $app->halt(401, $message);
        }
    }
});

// Run the application //
$app->run();


