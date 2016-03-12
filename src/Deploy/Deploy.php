<?php

namespace RoundPartner\Deploy;

use RoundPartner\Deploy\Plan\PlanFactory;

class Deploy
{

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

    /**
     * @return bool
     */
    public function dispatch()
    {
        if (!$this->request->verify($this->secret)) {
            return false;
        }

        $plan = $this->getPlan();
        if (!$plan) {
            return false;
        }

        $response = $plan->dispatch();

        if (!$this->shell && !$response) {
            echo 'Running plan failed.' . PHP_EOL;
        }

        if (!$this->shell) {
            echo 'Request Complete, nothing processed.' . PHP_EOL;
        }

        return true;
    }

    /**
     * @return Plan\Plan|bool
     */
    protected function getPlan()
    {
        try {
            return PlanFactory::createPlan($this->container, $this->request->getBody());
        } catch (\Exception $exception) {
            if (!$this->shell) {
                echo $exception->getMessage() . PHP_EOL;
            }
            return false;
        }
    }
}
