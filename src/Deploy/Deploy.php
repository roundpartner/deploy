<?php

namespace Deploy;

class Deploy {

    /**
     * @var Request
     */
    protected $request;

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

        $this->request = new Request($headers, $body);
        $this->secret = $secret;
    }

    public function dispatch()
    {
        if (!$this->request->verify($this->secret)) {
            return false;
        }

        if (!$this->shell) {
            echo 'Request Complete, nothing processed';
        }
        return true;
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
