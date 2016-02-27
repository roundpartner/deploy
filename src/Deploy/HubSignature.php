<?php

namespace Deploy;

class HubSignature
{

    /**
     * @var string
     */
    protected $secret;

    /**
     * HubSignature constructor.
     *
     * @param string $secret
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function verify(Request $request)
    {
        $signature = $request->getHeader('X-Hub-Signature');
        list($algorithm, $requestHash) = explode('=', $signature) + ["",""];

        if (!in_array($algorithm, hash_algos(), true)) {
            return false;
        }

        $bodyHash = hash_hmac($algorithm, $request->getRawBody(), $this->secret);

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
