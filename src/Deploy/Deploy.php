<?php

namespace Deploy;

use Deploy\Plan\PlanFactory;
use RoundPartner\Deploy\Container;

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
     * @var Container
     */
    protected $container;

    /**
     * Deploy constructor.
     *
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     * @param $container
     */
    public function __construct($headers, $body, $secret, Container $container)
    {
        $this->shell = isset($_SERVER['SHELL']);

        $this->request = new Request($headers, $body);
        $this->secret = $secret;

        $this->container = $container;
    }

    public function dispatch()
    {
        if (!$this->request->verify($this->secret)) {
            return false;
        }

        $plan = PlanFactory::createPlan($this->request->getBody());
        if (!$this->shell && !$plan->dispatch()) {
            echo 'Running plan failed';
        }

        if (!$this->shell) {
            echo 'Request Complete, nothing processed';
        }

        return true;
    }

}

