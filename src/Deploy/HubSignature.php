<?php

namespace Deploy;

class HubSignature
{

    /**
     * @var string
     */
    protected $secret;

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
        $headers = $request->getHeaders();
        $signature = $headers['X-Hub-Signature'];
        list($algorithm, $requestHash) = explode('=', $signature) + ["",""];

        if (!in_array($algorithm, hash_algos(), true)) {
            return false;
        }

        $bodyHash = hash_hmac($algorithm, $request->getBody(), $this->secret);

        if (hash_equals($bodyHash, $requestHash)) {
            return true;
        }

        return false;
    }

}