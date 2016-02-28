<?php

namespace Deploy;

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

        if (!$this->shell) {
            echo 'Request Complete, nothing processed';
        }

        $plan = PlanFactory::createPlan($this->request->getBody());

        return true;
    }

}

