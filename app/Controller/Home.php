<?php
/**
 * Purpose:
 *  Home controller
 * History:
 *  110517 - Lincoln: Created File
 */

$app->get('/:route', function () use ($app) {

    $data = array(
        'title' => 'Welcome to Spring notes',
        'header' => 'Welcome to Spring Notes',
    );

    $app->render('home/index', $data);
})->conditions(array('route' => '(|home)'))->name('home');