<?php

namespace Deploy;

use Cloud\Cloud;
use Deploy\Plan\PlanFactory;

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
     * Deploy constructor.
     *
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     */
    public function __construct($headers, $body, $secret)
    {
        $this->shell = isset($_SERVER['SHELL']);

        $this->request = new Request($headers, $body);
        $this->secret = $secret;
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

