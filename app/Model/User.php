<?php

/**
 * Purpose:
 *  Class for maintaining user information
 * History:
 *  110517 - Lincoln: Created file
 */

namespace Spring_App\Model;

use Spring_App\Utility\Session;
use Spring_App\Utility\Logger\Log;
use Spring_App\Utility\DB;
use \PDO;

/**
 * Class User
 * @package Model
 */
class User {

    /**
     * Username
     * @var int
     */
    private $id = 0;

    /**
     * Full name
     * @var string
     */
    private $name = '';

    /**
     * Email
     * @var string
     */
    private $email = '';

    /**
     * Password
     * @var string
     */
    private $password = '';

    /**
     * Created time
     * @var string
     */
    private $created_at = '';

    /**
     * Updated time
     * @var string
     */
    private $updated_at = '';

    /**
     * Session Data
     * @var Session
     */
    private $session;

    /**
     * Logging object
     * @var Log
     */
    private $log;

    /**
     * Database object
     * @var \PDO
     */
    private $db;

    /**
     * Checks if user is logged in Sets up groups
     * @param Session $session
     * @throws \RuntimeException
     */
    public function __construct(Session $session) {
        $this->session = $session;
        $this->log = new Log([], 'User');
        $db = new DB(loadConfig('db'));
        $this->db = $db->getConn();
        $this->fillUser();
    }

    /**
     * Gets user's username
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets the user's id
     * @return int
     */
    public function getID() {
        return $this->id;
    }

    /**
     * Checks to see if the user is currently logged in
     * @return bool
     */
    public function checkLogin() {
        return $this->session->checkLogin();
    }

    /**
     * Logs the user into the application and sets up session data
     * @param string $email User's email
     * @param string $password User's password
     * @return bool
     */
    public function login($email, $password) {
        try {
            $sql = 'SELECT id, name, email, password, created_at, updated_at FROM users WHERE email = :email';

            // Prepare and fetch user data //
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check that we got a match from the database //
            if ($results !== false) {
                // Verify the password //
                if (password_verify($password, $results['password'])) {
                    // Set the session login to true //
                    $this->session->login(true);

                    // Setup user data //
                    $ud = array(
                        'id' => (int) $results['id'],
                        'name' => $results['name'],
                        'email' => $results['email'],
                    );

                    // Inject user data into the session //
                    $this->session->setData('user', $ud);

                    // Fill the instance with the user data //
                    $this->fillUser();

                    return true;
                }
            }

            return false;
        } catch (\PDOException $e) {
            $this->log->exLog($e, __METHOD__);
        }

        return false;
    }

    /**
     * Registers a new user into the database
     * @param $data
     * @return string success|error|duplicate|exception
     */
    public function register($data) {
        try {
            $sql = 'INSERT INTO users (name,email,password) VALUES(:name, :email,:password)';

            $password = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue('name', $data['username']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':password', $password);
            $results = $stmt->execute();

            // If successful, lets log them in //
            if ($results) {
                $this->login($data['email'], $data['password']);

                return 'success';
            } else {
                return 'error';
            }

        } catch (\PDOException $ex) {
            $this->log->exLog($ex, __METHOD__);

            if ($ex->getCode() === '23000') {
                return 'duplicate';
            }

            return 'exception';
        }
    }

    /**
     * Logs the user out of application and destroys the session
     * @return bool
     */
    public function logout() {
        return $this->session->logOut();
    }

    /**
     * Populates the user class properties
     */
    private function fillUser() {
        // Check if we have the data //
        $user = $this->session->getData('user');

        // Check it's valid //
        if ($user !== null) {
            // Loop through and set the data //
            foreach ($user as $uk => $uv) {
                // Dynamically populate properties //
                $this->{$uk} = $uv;
            }
        }
    }

}