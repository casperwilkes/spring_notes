<?php

/**
 * Purpose:
 *  Controls session data
 * History:
 *  110517 - Lincoln: Created file
 */

namespace Spring_App\Utility;

/**
 * Class Session
 * @package Spring_App\Utility
 */
class Session {

    /**
     * Holds the data in the $_SESSION variable.
     * @var array
     */
    protected $data = array('messages' => array());

    /**
     * The login status.
     * @var bool
     */
    private $logged_in = false;

    /**
     * Starts the session and checks for data.
     */
    public function __construct() {
        if (session_id() === '') {
            session_start();
        }

        $this->checkSession();
    }

    /**
     * Sets data keys and values.
     * @param string $key The key value.
     * @param string $value The data value.
     */
    public function setData($key, $value) {
        $this->data[$key] = $_SESSION[$key] = $value;
    }

    /**
     * Retrieves data from the array. If no key is set it
     * returns the whole array. If key parameter is not set,
     * it returns a NULL value.
     * @param string $key The key to retrieve
     * @return mixed|null
     */
    public function getData($key = '') {
        if ($key !== '') {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }

            return null;
        }

        return $this->data;
    }

    /**
     * Removes selected key from session if it exists
     * @param string $key The key to remove
     * @return bool
     */
    public function clearData($key = '') {
        // Check if key is not empty and does exist in data //
        if ($key !== '' && isset($this->data[$key])) {
            unset($this->data[$key]);

            return true;
        }

        return false;
    }

    /**
     * Checks the login status.
     * @return bool
     */
    public function checkLogin() {
        return $this->logged_in;
    }

    /**
     * Logs the user out of the system.
     */
    public function logOut() {
        // Check if we have a session cookie active //
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600);
        }

        // Set login to false //
        $this->logged_in = false;

        // Destroy the session //
        return session_destroy();
    }

    /**
     * Passes true or false value to log the user in
     * @param boolean $login
     */
    public function login($login) {
        if ($login === true) {
            $this->logged_in = $_SESSION['logged_in'] = true;
        }
    }

    /**
     * Checks to see if the $_SESSION data is set and available.
     * If it is, it inserts itself into the $data array.
     */
    private function checkSession() {
        if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'])) {
            $this->data = $_SESSION;
            $this->logged_in = true;
        }
    }

}
