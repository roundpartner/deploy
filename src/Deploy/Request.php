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

    /**
     * @return string[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}