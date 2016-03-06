<?php

namespace RoundPartner\Deploy;

class Bootstrap
{

    /**
     * @var Deploy
     */
    protected $deploy;

    /**
     * Bootstrap constructor.
     *
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     */
    public function __construct($headers, $body, $secret)
    {
        $container = new Container();
        $this->deploy = new Deploy($headers, $body, $secret, $container);
    }

    /**
     *
     */
    public function dispatch()
    {
        $this->deploy->dispatch();
    }
}