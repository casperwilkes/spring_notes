<?php

/**
 * Purpose:
 *  Logging mechanism for errors and messages to specific logs
 * History:
 *  110517 - Lincoln: Created file
 */

namespace Spring_App\Utility\Logger;

/**
 * Class Logger
 * @package Spring_App\Utility\Logger
 */
class Logger {

    /**
     * Sets the current file path.
     * @var string
     */
    private $log;

    /**
     * Catches all of the errors and creates a string indexed array.
     * @var array
     */
    private $message_array = array();

    /**
     * Sets up config options for Simple Logger
     * @var array
     */
    private $config = array();

    /**
     * Sets up the configuration for the logger, and a general log file to write
     *  to if provided
     * @param array $config Array of configuration options
     * @param string $log Name of the logfile
     */
    public function __construct(array $config = array(), $log = '') {
        // Set up the config options //
        $this->setBaseConfig();
        $this->setConfig($config);
        // Set up log to write to if provided //
        $this->setLog($log);
    }

    /**
     * Set the log file to use.
     * - Defaults to general.txt if nothing is provided.
     * @param string $log
     */
    public function setLog($log = '') {
        // Log to write to //
        // If name was specified, use that, else use default //
        $log = ($log !== '' ? $log : $this->config['default_log']) . '.txt';
        // Full destination path //
        $destination = $this->config['log_path'] . $this->config['logs_dir'];

        // If destination doesn't exist, create it //
        if (!realpath($destination)) {
            mkdir($destination, 0775);
        }

        // Set this log up to write to //
        $this->log = $destination . strtolower($log);
    }

    /**
     * Creates Exception specific logs.
     * @param \Exception $e The Exception object
     * @param string $context The method the exception happened in.
     */
    public function exLog(\Exception $e, $context = 'Not Given') {
        $this->message_array = array(
            'Time' => $this->setTime(),
            'Type' => basename(get_class($e)),
            'Context' => $context,
            'Code' => $e->getCode(),
            'File' => $e->getFile(),
            'Line' => $e->getLine(),
            'Message' => preg_replace('/\s\s+/', ' ', $e->getMessage()),
            'Trace' => preg_replace('/\n/', ' ', $e->getTraceAsString()),
        );

        $this->logError();
    }

    /**
     * Creates a generalized error log. Accepts arrays, objects, or strings
     * @param string|array $message Message to output to log
     * @param string $context Method message occurred in: generally __METHOD__
     * @param string $level Type of message, Defaults to config default_level, can be anything
     */
    public function genLog($message, $context = '', $level = '') {
        // Get a backtrace //
        $bt = debug_backtrace();
        // Build error array //
        $this->message_array['Time'] = $this->setTime();
        // The file that the log was called in //
        $this->message_array['File'] = $bt[1]['file'];
        // The line the log was called in //
        $this->message_array['line'] = $bt[1]['line'];
        // Log type //
        $this->message_array['Type'] = $level !== '' ? $level : $this->config['default_level'];

        // If context was specified //
        if ($context !== '') {
            $this->message_array['context'] = $context;
        }

        // Break down message //
        if (is_array($message)) {

            if ($this->config['multi'] === 'print') {
                $this->message_array['Data'] = print_r($message, true);
            }
            if ($this->config['multi'] === 'json') {
                $this->message_array['Data'] = json_encode($message);
            }
        } else {
            $this->message_array['Message'] = $message;
        }

        // Output the error log //
        $this->logError();
    }

    /**
     * Used when deleting logs from admin section.
     * @return bool
     */
    public function deleteLog() {
        return unlink($this->log);
    }

    /**
     * Fetch all log names
     * @return array
     */
    public function fetchLogs() {
        $logs = array();
        // Iterate through directory and get all file names //
        foreach (new \DirectoryIterator(SITE_ROOT . DIRECTORY_SEPARATOR . 'logs') as $file) {
            // Make sure not to get . or .. or the .gitkeep file //
            if (!$file->isDot() && $file->getFilename() !== '.gitkeep') {
                $logs[] = $file->getBasename('.txt');
            }
        }

        return $logs;
    }

    /**
     * Sets up any additional config options
     * @param array $config_array The configuration array
     */
    public function setConfig(array $config_array) {
        if (!empty($config_array)) {
            foreach ($config_array as $k => $v) {
                $this->config[$k] = $v;
            }
        }
    }

    /**
     * Set the time property.
     */
    private function setTime() {
        return strftime($this->config['time_format'], time());
    }

    /**
     * Logs the errors to the specified log file.
     */
    private function logError() {
        // Test if file is new //
        $new = file_exists($this->log);

        // Serialize message for space //
        $message = $this->setError();

        // Write message to file //
        $handle = fopen($this->log, 'ab');

        if ($handle !== false) {
            fwrite($handle, $message);
            fclose($handle);
        }

        // If new file, make sure we keep it writable //
        if (!$new) {
            chmod($this->log, 0775);
        }

        // Reset message array //
        $this->message_array = [];
    }

    /**
     * Sets up the base config options
     */
    private function setBaseConfig() {
        $this->config = loadConfig('logger');
    }

    /**
     * Set up the message for logging
     * @return string
     */
    private function setError() {
        $error = '';

        if ($this->config['serialize']) {
            $error = base64_encode(serialize($this->message_array));
        } else {
            foreach ($this->message_array as $k => $v) {
                $error .= sprintf("%s: %s\n", $k, $v);
            }
        }

        return $error . PHP_EOL;
    }

    /**
     * Gets the error for viewing logs in customized viewer
     * @todo finish - made private to stop access
     */
    private function getError() {
        // if ($this->config['serialize']) {
        //
        // }
    }

    /**
     * Used in admin section to view error logs.
     * @todo finish - Note: Made private to stop access
     */
    private function fetchErrors() {
        // // Make sure that log is accessible //
        // if (file_exists($this->log) && is_readable($this->log) && $handle = fopen($this->log, 'r')) {
        //     $i = 0;
        //     $message = array();
        //     while (!feof($handle)) {
        //         // Get each line //
        //         $entry = fgets($handle);
        //         // Unserialize for reading //
        //         $message[$i] = unserialize(base64_decode($entry));
        //         $i++;
        //     }
        //
        //     fclose($handle);
        //
        //     // remove empty lines //
        //     if (empty($message[$i - 1])) {
        //         unset($message[$i - 1]);
        //     }
        //
        //     return $message;
        // } else {
        //     return "Could not read from {$this->log}.";
        // }
    }
}
