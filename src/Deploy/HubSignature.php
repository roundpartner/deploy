<?php

namespace Deploy;

class HubSignature
{

    const HEADER_HUB_SIGNATURE = 'X-Hub-Signature';
    const DEFAULT_ALGORITHM = 'sha1';

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
        $signature = $request->getHeader(self::HEADER_HUB_SIGNATURE);
        list($algorithm, $requestHash) = explode('=', $signature) + ["",""];

        $bodyHash = $this->getHash($request->getRawBody(), $algorithm);

        if ($bodyHash !== false && $this->hashEquals($bodyHash, $requestHash)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $content
     * @param string $algorithm
     * @return bool|string
     */
    public function getHash($content, $algorithm = self::DEFAULT_ALGORITHM)
    {
        if (!is_string($content)) {
            return false;
        }

        if (!in_array($algorithm, hash_algos(), true)) {
            return false;
        }

        return hash_hmac($algorithm, $content, $this->secret);
    }

    /**
     * String comparison for hashes
     *
     * @param $knownString
     * @param $userString
     * @return bool
     */
    private function hashEquals($knownString, $userString)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($knownString, $userString);
        }

        if (strlen($knownString) !== strlen($userString)) {
            return false;
        }

        $res = $knownString ^ $userString;
        $ret = 0;
        for ($i = strlen($res) - 1; $i >= 0; $i--) {
            $ret |= ord($res[$i]);
        }
        return !$ret;
    }

}
