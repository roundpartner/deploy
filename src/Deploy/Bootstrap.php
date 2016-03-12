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
     * @param Container $container
     */
    public function __construct($headers, $body, $secret, $container = null)
    {
        $request = new Request($headers, $body);
        if ($container === null) {
            $container = new Container();
        }
        $this->deploy = new Deploy($request, $secret, $container);
    }

    /**
     * @return bool
     */
    public function dispatch()
    {
        return $this->deploy->dispatch();
    }
}