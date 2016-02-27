<?php

namespace Deploy;

class Request
{

    /**
     * @var string[]
     */
    protected $headers;

    /**
     * @var string
     */
    protected $body;

    public function __construct($headers, $body)
    {
        $this->headers = $headers;
        $this->body = $body;
    }

    public function verify($secret)
    {
        $hubSignature = new HubSignature($secret);
        return $hubSignature->verify($this);
    }

    /**
     * @return string[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param $header
     * @return false|string
     */
    public function getHeader($header)
    {
        if (!isset($this->headers[$header])) {
            return false;
        }
        return $this->headers[$header];
    }

    /**
     * @return string
     */
    public function getRawBody()
    {
        return $this->body;
    }
}