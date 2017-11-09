<?php

/**
 * Purpose:
 *  Manage user account information
 * History:
 *  110417 - Lincoln: Created file
 */

$app->group('/users', function () use ($app, $user, $messenger, $log) {
    // Set the log //
    $log->setLog('users');

    /**
     * Login page
     */
    $app->map('/login', function () use ($app, $user, $messenger, $log) {
        // Check if user is currently logged in //
        if ($user->checkLogin()) {
            // Redirect back to home //
            $app->redirect('home');
        }

        // Initial form values //
        $pd = array(
            'email' => '',
            'password' => '',
        );

        // Check if we've gotten a post request //
        if ($app->request->isPost()) {
            // Get the post variables //
            $pd = $app->request->post();

            $email = filter_var(filter_var($pd['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            $password = filter_var($pd['password'], FILTER_SANITIZE_STRING);

            // Check valid email //
            if ($email === false) {
                $messenger->setMessage('error', 'Invalid Email');
            }

            // Check valid password //
            if ($password === '') {
                $messenger->setMessage('error', 'Invalid Password');
            }

            // If we've gotten a valid email/password combo //
            if ($email && $password) {
                // Log them in //
                if ($user->login($email, $password)) {
                    $messenger->setMessage('success', 'Welcome back ' . ucwords($user->getName()));
                    $app->redirect('home');
                } else {
                    $messenger->setMessage('error', 'Unable to validate login at this time. Please try again later.');
                    $msg = array(
                        'message' => 'Invalid login attempt',
                        'email' => $email,
                    );
                    $log->warning($msg);
                }
            }
        }

        $data = array(
            'title' => 'Login to Spring Notes!',
            'header' => 'Login to Spring Notes',
            'email' => $pd['email'],
            'password' => $pd['password'],
        );

        $app->render('users/login', $data);
    })->via('GET', 'POST')->name('login');

    /**
     * Logout page
     */
    $app->get('/logout', function () use ($app, $user, $messenger, $log) {
        // Check user isn't actually logged in //
        if (!$user->checkLogin()) {
            // Redirect them to the login page //
            $app->redirect('login');
        }

        // Attempt to log user out //
        if ($user->logout()) {
            $messenger->setMessage('success', 'You have been successfully logged out');
        } else {
            $messenger->setMessage('error', 'Could not log you out at this time.');

            // Log error //
            $msg = array(
                'message' => 'Could not log out user',
                'User id' => $user->getID(),
                'User name' => $user->getName(),
            );

            $log->warning($msg);
        }

        $app->redirect('home');
    })->name('logout');

    /**
     * Registrations page
     */
    $app->map('/register', function () use ($app, $user, $messenger, $log) {
        if ($user->checkLogin()) {
            $app->redirect('home');
        }

        // Initial Form vars //
        $pd = array(
            'email' => '',
            'username' => '',
            'password' => '',
            'vpassword' => '',
        );
        // Password match //
        $match = false;

        if ($app->request->isPost()) {
            // Get the post variables //
            $pd = $app->request->post();

            // Get submitted values //
            $submit = array(
                'email' => filter_var(filter_var($pd['email'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL),
                'username' => filter_var($pd['username'], FILTER_SANITIZE_STRING),
                'password' => filter_var($pd['password'], FILTER_SANITIZE_STRING),
                'verify_password' => filter_var($pd['vpassword'], FILTER_SANITIZE_STRING),
            );

            // Checks //
            foreach ($submit as $k => $v) {
                if ($v === false || $v === '') {
                    $value = ucwords(str_replace('_', ' ', $k));
                    $messenger->setMessage('error', "Invalid {$value}");
                }
            }

            if ($submit['password'] !== $submit['verify_password']) {
                $messenger->setMessage('error', 'Password and Verify Password must be identical');
            } else {
                $match = true;
            }

            // Check no empty or false elements, check we have a match //
            if ($match && !in_array(false, $submit, true) && !in_array('', $submit, true)) {
                // Register the user //
                $register = $user->register($submit);

                // Duplicates are unique //
                if ($register === 'duplicate') {
                    $messenger->setMessage('error', 'User already exists');
                    $msg = array(
                        'message' => 'Attempt to re-register account',
                        'user' => $submit['username'],
                        'email' => $submit['email'],
                    );

                    $log->warning($msg);
                } elseif ($register === 'success') {
                    // Successful, so message and redirect home //
                    $messenger->setMessage('success', 'Welcome to Spring Notes ' . ucwords($user->getName()));
                    $app->redirect('home');
                } else {
                    // Something else occurred, log it and display message //
                    $messenger->setMessage('error', "An {$register} has occurred, please try again later");
                    $msg = array(
                        'message' => 'Unable to register user',
                        'username' => $submit['username'],
                        'email' => $submit['email'],
                    );
                    $log->error($msg);
                }
            }
        }

        // Template data //
        $data = array(
            'header' => 'Register An Account',
            'email' => $pd['email'],
            'username' => $pd['username'],
            'password' => $pd['password'],
            'vpassword' => $pd['vpassword'],
        );

        $app->render('users/register', $data);
    })->via('GET', 'POST')->name('register');
});
