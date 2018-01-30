<?php

namespace RoundPartner\Deploy;

use RoundPartner\Deploy\Exception\NoPlanException;
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
        $this->request = $request;
        $this->secret = $secret;

        $this->container = $container;
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    public function dispatch()
    {
        if (!$this->request->verify($this->secret)) {
            $this->container->getLogger()->addError('Secret verification failed');
            return false;
        }

        if ($this->request->getBody()->ref !== 'refs/heads/master') {
            $this->container->getLogger()->addInfo('Skipping deployment: ' . $this->request->getBody()->ref);
            return false;
        }

        $plan = $this->getPlan();
        if (!$plan) {
            return false;
        }

        $this->container->getLogger()->addInfo('Dispatching plan');
        return $plan->dispatch();
    }

    /**
     * @return Plan\Plan|bool
     *
     * @throws \Exception
     */
    protected function getPlan()
    {
        try {
            return PlanFactory::createPlan($this->container, $this->request->getBody());
        } catch (NoPlanException $exception) {
            $this->container->getLogger()->addInfo($exception->getMessage());
        } catch (\Exception $exception) {
            $this->container->getLogger()->addError($exception->getMessage());
            return false;
        }
    }
}
