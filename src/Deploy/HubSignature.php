<?php

namespace RoundPartner\Deploy;

use \RoundPartner\VerifyHash\VerifyHash;

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

        $verifyHash = new VerifyHash($this->secret);
        return $verifyHash->verify($requestHash, $request->getRawBody(), $algorithm);
    }
}
