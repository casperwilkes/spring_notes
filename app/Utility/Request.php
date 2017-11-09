<?php

/**
 * Purpose:
 *  Simple reusable request class
 * History:
 *  110517 - Lincoln: Created file
 */

namespace Spring_App\Utility;

use Curl\Curl;
use Spring_App\Utility\Logger\Log;

/**
 * Class Request
 * @package Spring_App\Utility
 */
class Request {

    /**
     * Curl object
     * @var Curl
     */
    private $curl;

    /**
     * Logging object
     * @var Log
     */
    private $log;

    /**
     * Headers to send with request
     * @var array
     */
    private $headers = array(
        'Content-Type',
        'application/json',
    );

    public function __construct() {
        $this->curl = new Curl();
        $this->log = new Log([], 'request');
    }

    /**
     * Sends a curl request to web service
     * @param string $url Url to request data from
     * @param string $type Type of request [get|post|push|delete]
     * @param array $data array of data to send
     * @return mixed
     */
    public function sendRequest($url, $type = 'get', array $data = array()) {
        try {
            $this->curl->setHeaders($this->headers);
            $this->curl->setJsonDecoder(false);
            $this->curl->{$type}($url, json_encode($data));

            return json_decode($this->curl->response, true);
        } catch (\Exception $e) {
            $this->log->exLog($e, __METHOD__);

            return false;
        }
    }

    /**
     * Closes curl handle
     */
    public function __destruct() {
        $this->curl->close();
    }
}