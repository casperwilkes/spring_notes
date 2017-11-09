<?php
/**
 * Purpose:
 *  Simple class to control messaging across the application
 * History:
 *  110717 - Lincoln: Created class
 */

namespace Spring_App\Utility;

/**
 * Class Messenger
 * @package Spring_App\Utility
 */
class Messenger extends Session {

    /**
     * Messenger constructor.
     * Instantiates the messages within the session and instantiates the parent class
     */
    public function __construct() {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        }

        parent::__construct();
    }

    /**
     * Sets up session messages
     * @param string $type Type of message. Types use either the first letter, or the word of what's being set.
     *  Types: ['error','info','success','warning'] || ['e','i','s','w']
     * @param string|array $message Message(s) to pass to the user
     * @example setMessage('e', 'error message');
     * @example setMessage('error', array('these', 'are', 'problems'));
     * @throws \InvalidArgumentException If correct type not sent
     */
    public function setMessage($type, $message) {
        // Make sure we're getting the right type //
        if (!is_string($message) && !is_array($message)) {
            throw new \InvalidArgumentException('Cannot set message of invalid type');
        }

        // Check the type //
        // Allow for short hand //
        switch ($type) {
            case'e':
            case 'error':
                $mc = 'error';
                break;
            case 'i':
            case 'info':
                $mc = 'info';
                break;
            case 's':
            case 'success':
                $mc = 'success';
                break;
            case 'w':
            case 'warning':
                $mc = 'warning';
                break;
            default:
                $mc = '';
                break;
        }

        // Get the current messages //
        $m = $this->data['messages'];

        // If it's a string or array //
        if (is_string($message)) {
            $m[] = array('type' => $mc, 'message' => $message);
        } else {
            // Loop through the messages //
            foreach ($message as $mess) {
                $m[] = array('type' => $mc, 'message' => $mess);
            }
        }

        // Set the data //
        $this->setData('messages', $m);
    }

    /**
     * Gets all the messages stored in the session. After message is retrieved, it is removed from the session
     * @return array
     */
    public function getMessages() {
        // Get the messages out of the session //
        $messages = $this->data['messages'];

        // If messages exist //
        if (!empty($messages)) {
            // We clear them out because they've been retrieved //
            $this->data['messages'] = $_SESSION['messages'] = array();
        }

        // Return the messages //
        return $messages;
    }

    /**
     * Counts the number of current messages in the session
     * @return int
     */
    public function count() {
        return count($this->data['messages']);
    }
}