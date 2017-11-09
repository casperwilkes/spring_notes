<?php

/**
 * Purpose:
 *  Minified class for just doing log levels
 * History:
 *  110517 - Lincoln: Created file
 */

namespace Spring_App\Utility\Logger;

/**
 * Class Log
 * @package Spring_App\Utility\Logger
 */
class Log extends Logger {

    /**
     * Creates an Alert log message
     * @param string|array $message Message to output to log
     * @param string $context Method message occurred in: generally __METHOD__
     */
    public function alert($message, $context = '') {
        $this->genLog($message, $context, 'Alert');
    }

    /**
     * Creates a Critical log message
     * @param string|array $message Message to output to log
     * @param string $context Method message occurred in: generally __METHOD__
     */
    public function critical($message, $context = '') {
        $this->genLog($message, $context, 'Critical');
    }

    /**
     * Creates an Error log message
     * @param string|array $message Message to output to log
     * @param string $context Method message occurred in: generally __METHOD__
     */
    public function error($message, $context = '') {
        $this->genLog($message, $context, 'Error');
    }

    /**
     * Creates a Warning log message
     * @param string|array $message Message to output to log
     * @param string $context Method message occurred in: generally __METHOD__
     */
    public function warning($message, $context = '') {
        $this->genLog($message, $context, 'Warning');
    }

    /**
     * Creates a Notice log message
     * @param string|array $message Message to output to log
     * @param string $context Method message occurred in: generally __METHOD__
     */
    public function notice($message, $context = '') {
        $this->genLog($message, $context, 'Notice');
    }

    /**
     * Creates an Info log message
     * @param string|array $message Message to output to log
     * @param string $context Method message occurred in: generally __METHOD__
     */
    public function info($message, $context = '') {
        $this->genLog($message, $context, 'Info');
    }

    /**
     * Creates a Debug log message
     * @param string|array $message Message to output to log
     * @param string $context Method message occurred in: generally __METHOD__
     */
    public function debug($message, $context = '') {
        $this->genLog($message, $context, 'Debug');
    }

}
