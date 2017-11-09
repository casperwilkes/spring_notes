<?php
/**
 * Purpose:
 *  Notes Controller
 * History:
 *  110517 - Lincoln: Created File
 */

use Spring_App\Utility\Request;

/**
 * Notes base group
 */
$app->group('/notes', function () use ($app, $user, $messenger, $log) {
    // Set the log //
    $log->setLog('notes');

    // Check user is logged in //
    $check_login = function () use ($app, $user, $messenger) {
        // Check login status //
        if (!$user->checkLogin()) {
            // Send user a message //
            $messenger->setMessage('warning', 'You must be logged in to view notes');
            // Redirect them back home //
            $app->redirect($app->urlFor('home', array('route' => '')));
        }
    };

    // Tokens needed to talk with api //
    $token_string = function () {
        $tokens = loadConfig('app_tokens');

        return "?name={$tokens['name']}&key={$tokens['key']}&token={$tokens['token']}";
    };

    // Set the API url //
    $api = $app->environment['FULL_PATH'] . '/v1/notes';

    // Request object //
    $request = new Request();

    /**
     * Gets all notes for logged in user
     */
    $app->get('/', $check_login, function () use ($app, $user, $api, $log, $request, $token_string) {
        $user_id = $user->getID();

        $notes = array();

        // Request data //
        $note_data = $request->sendRequest($api . "/{$user_id}/user_id" . $token_string());

        // Check for errors //
        if (!empty($note_data['error'])) {
            $log->error($note_data['error']);
        } else {
            $notes = $note_data['results'];
        }

        // Template data //
        $data = array(
            'title' => 'Your notes page',
            'header' => 'Your Notes',
            'notes' => $notes,
        );

        $app->render('notes/index', $data);
    })->name('notes');

    /**
     * View a single note
     */
    $app->get('/:id', $check_login, function ($id) use ($app, $api, $log, $request, $token_string) {
        // note array //
        $note = array();

        // Note request data //
        $note_data = $request->sendRequest($api . '/' . $id . $token_string());

        // Check for errors //
        if (!empty($note_data['error'])) {
            $log->error($note_data['error']);
        } else {
            $note = $note_data['results'];
        }

        // Output to template //
        $data = array(
            'header' => "Viewing note:{$id}",
            'note' => $note,
        );

        $app->render('notes/view', $data);
    })->conditions(array('id' => '\d*'))->name('view_note');

    /**
     * Create a new note
     */
    $app->map('/create', $check_login, function () use ($app, $user, $api, $request, $messenger, $token_string, $log) {
        // Default template vars //
        $title = '';
        $body = '';

        // Check if we got a post request //
        if ($app->request->isPost()) {
            // Sanitize our inputs //
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

            // Validation //
            if ($title === '') {
                $messenger->setMessage('error', 'Title cannot be empty');
            }
            if ($body === '') {
                $messenger->setMessage('error', 'body cannot be empty');
            }

            // Check for empties //
            if (($title && $title !== '') && ($body && $body !== '')) {
                // Request data //
                $data = array(
                    'user_id' => $user->getID(),
                    'title' => $title,
                    'body' => $body,
                );

                // Make the request //
                $response = $request->sendRequest($api . $token_string(), 'post', $data);

                // Check that we got back the created id //
                if (is_int($response['results'])) {
                    $messenger->setMessage('success', 'A new note was created');
                    $app->redirect($app->urlFor('notes'));
                } else {
                    // Otherwise, it's an error //
                    $messenger->setMessage('error', 'Could not create new note at this time, please try again.');
                    $log->error($response['error']);
                }
            }

        }

        // Template data //
        $data = array(
            'header' => 'Create a new note',
            'title' => $title,
            'body' => $body,
            'action' => 'notes/create',
        );

        $app->render('notes/create', $data);
    })->via('GET', 'POST')->name('create_note');

    /**
     * Edit a note
     */
    $app->map('/edit/:id', $check_login, function ($id) use ($app, $user, $api, $request, $token_string, $messenger, $log) {
        // Default vars //
        $title = '';
        $body = '';

        // Check if we got a post request //
        if ($app->request->isPost()) {
            // Filter the strings //
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

            // empty validation //
            if ($title === '') {
                $messenger->setMessage('error', 'Title cannot be empty');
            }
            if ($body === '') {
                $messenger->setMessage('error', 'body cannot be empty');
            }

            // Not empty send request //
            if (($title && $title !== '') && ($body && $body !== '')) {
                // Request data //
                $data = array(
                    'user_id' => $user->getID(),
                    'title' => $title,
                    'body' => $body,
                );

                // Send the request //
                $response = $request->sendRequest("{$api}/{$id}" . $token_string(), 'put', $data);

                // Check the response //
                if ($response['results']) {
                    $messenger->setMessage('success', 'Note updated');
                    $app->redirect($app->urlFor('notes'));
                } else {
                    $messenger->setMessage('error', 'Could not update note at this time');
                    $log->error($response['error']);
                }
            }
        } else {
            // Get the note //
            $note = $request->sendRequest("{$api}/{$id}" . $token_string());

            // Check for errors //
            if (empty($note['error'])) {
                if (!empty($note['results'])) {
                    $title = $note['results']['title'];
                    $body = $note['results']['body'];
                }
            } else {

                $log->error($note['error']);
            }
        }

        // Template data //
        $data = array(
            'header' => 'Edit note',
            'title' => $title,
            'body' => $body,
            'id' => $id,
            'action' => "notes/edit/{$id}",
        );

        $app->render('notes/edit', $data);
    })->via('GET', 'POST')->conditions(array('id' => '\d*'))->name('edit_note');

    /**
     * Delete a note
     */
    $app->get('/delete/:id', $check_login, function ($id) use ($app, $request, $api, $token_string, $messenger, $log) {
        // Send a request //
        $response = $request->sendRequest("{$api}/{$id}" . $token_string(), 'delete');

        // Check response //
        if ($response['results']) {
            $messenger->setMessage('success', 'Note successfully removed');
            $app->redirect($app->urlFor('notes'));
        } else {
            $messenger->setMessage('error', 'Could not remove note at this time.');
            $log->error($response['error']);
            $app->redirect($app->urlFor('view_note', array('id' => $id)));
        }
    })->conditions(array('id' => '\d*'))->name('delete_note');
});