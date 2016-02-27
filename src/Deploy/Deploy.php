<?php

namespace Deploy;

class Deploy {

    /**
     * @var string[]
     */
    protected $headers;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var bool
     */
    protected $shell;

    /**
     * Deploy constructor.
     *
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     */
    public function __construct($headers, $body, $secret)
    {
        $this->shell = isset($_SERVER['SHELL']);

        $this->headers = $headers;
        $this->body = $body;
        $this->secret = $secret;
    }

    public function dispatch()
    {
        if (!$this->shell) {
            echo 'Request Complete, nothing processed';
        }
        return true;
    }

    public function verifyRequest()
    {
        $signature = $this->headers['X-Hub-Signature'];
        list($algorithm, $requestHash) = explode('=', $signature) + ["",""];

        if (!in_array($algorithm, hash_algos(), true)) {
            return false;
        }

        $bodyHash = hash_hmac($algorithm, $this->body, $this->secret);

        if (hash_equals($bodyHash, $requestHash)) {
            return true;
        }

        return false;
    }
}


if (!function_exists('hash_equals')) {
    /**
     * Handles comparisons and prevents time attacks for php versions lesser than 5.6
     *
     * @param $str1
     * @param $str2
     * @return bool
     */
    function hash_equals($str1, $str2)
    {
        if (strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for ($i = strlen($res) - 1; $i >= 0; $i--) {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}
