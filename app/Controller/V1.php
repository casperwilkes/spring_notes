<?php

/**
 * Purpose:
 *  API controller
 * History:
 *  110517 - Lincoln: Created file
 *  111117 - Lincoln: Updated the update route
 */

use Spring_App\Model\Note;

/**
 * V1 routes
 */
$app->group('/v1', function () use ($app, $log) {
    // set log //
    $log->setLog('api');

    /**
     * Notes group
     */
    $app->group('/notes', function () use ($app, $log) {

        // Note object //
        $note = new Note();

        // Default JSON response body //
        $body = array(
            'results' => array(),
            'error' => array(),
        );

        /**
         * Returns an array containing all available notes
         */
        $app->get('/', function () use ($app, $note, $body) {
            $response = $note->getNotes();

            if (is_array($response)) {
                $body['results'] = $response;
            } else {
                $body['error'][] = array('message' => 'Unable to locate notes');
            }

            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setBody(json_encode($body));

        });

        /**
         * Returns a single note by id
         */
        $app->get('/:id', function ($id = null) use ($app, $note, $body) {
            if (!is_null($id)) {
                $response = $note->getNotes($id, 'note');
            } else {
                $app->response->setStatus(400);
                $body['error'][] = array(
                    'message' => 'ID Required to retrieve note',
                    'status' => $app->response->getStatus(),
                );
            }

            if (!$response) {
                $app->response->setStatus(400);
                $body['error'][] = array(
                    'message' => 'Unable to retrieve results for note id: ' . $id,
                    'status' => $app->response->getStatus(),
                );
            } else {
                $body['results'] = $response;
            }
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setBody(json_encode($body));
        })->conditions(array('id' => '\d*'));

        /**
         * Returns all notes for user id
         */
        $app->get('/:id/user_id', function ($id = null) use ($app, $note, $body) {
            if (!is_null($id)) {
                $response = $note->getNotes($id, 'user');
            } else {
                $app->response->setStatus(400);
                $body['error'][] = array(
                    'message' => 'ID Required to retrieve note',
                    'status' => $app->response->getStatus(),
                );
            }

            if (!$response) {
                $app->response->setStatus(400);
                $body['error'][] = array(
                    'message' => 'Unable to retrieve results for note id: ' . $id,
                    'status' => $app->response->getStatus(),
                );
            } else {
                $body['results'] = $response;
            }
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setBody(json_encode($body));
        })->conditions(array('id' => '\d*'));

        /**
         * Returns the last inserted id, or error message on failure
         */
        $app->post('/', function () use ($app, $note, $body) {
            $pd = $app->request->getBody();

            if (is_json($pd)) {
                $data = json_decode($pd, true);

                if ($data['user_id'] === '') {
                    $body['error'][] = array('message' => 'User id is a required field');
                }
                if ($data['title'] === '') {
                    $body['error'][] = array('message' => 'Note title is a required field');
                }
                if ($data['body'] === '') {
                    $body['error'][] = array('message' => 'Note body is a required field');
                }

                if (!in_array('', $data, true)) {
                    $results = $note->createNote($data);
                    if ($results === false) {
                        $body['error'][] = array('message' => 'Unable to create note at this time.');
                    } else {
                        $body['results'] = $results;
                    }
                }
            }

            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setBody(json_encode($body));
        });

        /**
         * Returns a true on success, error message on failure
         */
        $app->put('/:id', function ($id) use ($app, $note, $body) {
            $pd = $app->request->getBody();
            if (is_json($pd)) {
                $data = json_decode($pd, true);
                $data['id'] = $id;

                // Check body is not empty //
                if (!isset($data['id']) || $data['id'] === '') {
                    $body['error'][] = array('message' => 'User id is a required field');
                }

                // Check that we got a title or body //
                if (!isset($data['title']) && !isset($data['body'])) {
                    $body['error'][] = array('message' => 'Either title or body are required');
                }

                // Check our array doesn't have empty values //
                if (in_array('', $data, true)) {
                    $body['error'][] = array('message' => 'either title or body cannot be empty');
                } else {
                    // Send the update //
                    $results = $note->updateNote($data);
                    // Get results //
                    if ($results === false) {
                        $body['error'][] = array('message' => 'Unable to update note at this time.');
                    } else {
                        $body['results'] = $results;
                    }
                }
            }

            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setBody(json_encode($body));
        })->conditions(array('id' => '\d*'));

        /**
         * Returns true if note deleted, or error message on failure
         */
        $app->delete('/:id', function ($id = null) use ($app, $note, $body) {
            if (!is_null($id)) {
                if ($note->deleteNote($id)) {
                    $body['results'] = true;
                } else {
                    $body['error'] = array('message' => 'Unable to delete note at this time.');
                }
            } else {
                $body['error'] = array('message' => 'Must use a valid note id');
            }
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setBody(json_encode($body));
        })->conditions(array('id' => '\d*'));
    });
});