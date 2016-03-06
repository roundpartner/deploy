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
        $request = new Request($headers, $body);
        $container = new Container();
        $this->deploy = new Deploy($request, $secret, $container);
    }

    /**
     *
     */
    public function dispatch()
    {
        $this->deploy->dispatch();
    }
}