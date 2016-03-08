<?php

namespace RoundPartner\Deploy;

use RoundPartner\Deploy\Plan\PlanFactory;

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
     * @param Request $request
     * @param string $secret
     * @param $container
     */
    public function __construct(Request $request, $secret, Container $container)
    {
        $this->shell = isset($_SERVER['SHELL']);

        $this->request = $request;
        $this->secret = $secret;

        $this->container = $container;
    }

    public function dispatch()
    {
        if (!$this->request->verify($this->secret)) {
            return false;
        }

        $plan = PlanFactory::createPlan($this->container, $this->request->getBody());
        if (!$this->shell && !$plan->dispatch()) {
            echo 'Running plan failed';
        }

        if (!$this->shell) {
            echo 'Request Complete, nothing processed';
        }

        return true;
    }

}

