<?php

/**
 * Purpose:
 *  PDO Database instantiation class
 * History:
 *  110517 - Lincoln: Created class
 *
 */

namespace Spring_App\Utility;

use Spring_App\Utility\Logger\Log;
use PDO;
use PDOException;
use RuntimeException;

/**
 * Class DB
 * @package Spring_App\Utility
 */
class DB {

    /**
     * Database connection
     * @var PDO
     */
    private $conn;

    /**
     * DB constructor.
     * @param array $db Database credentials
     * @throws \RuntimeException
     */
    public function __construct(array $db = array()) {
        // Check that user specified db //
        if (!empty($db)) {
            try {
                // Load the config //
                $this->checkCreds($db);
                // Setup PDO connection
                $this->conn = new PDO($db['dsn'], $db['username'], $db['password']);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $pde) {
                $log = new Log([], 'Database');
                $log->exLog($pde, __METHOD__);
            }
        }
    }

    /**
     * Gets the database connection
     * @return PDO
     */
    public function getConn() {
        return $this->conn;
    }

    /**
     * Validates that creds are setup properly
     * @param array $creds Database credentials
     * @throws \RuntimeException
     */
    private function checkCreds(array $creds) {
        // Check dsn set //
        if (!isset($creds['dsn'])) {
            throw new RuntimeException('Invalid database credentials: dsn');
        }
        // Check username is set //
        if (!isset($creds['username'])) {
            throw new RuntimeException('Invalid database credentials: username');
        }
        // Check password set //
        if (!isset($creds['password'])) {
            throw new RuntimeException('Invalid database credentials: password');
        }
    }

}