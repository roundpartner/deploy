<?php

namespace RoundPartner\Deploy\Server;

use RoundPartner\Cloud\Message\Message;
use RoundPartner\Cloud\Queue\PollFactory;
use RoundPartner\Deploy\Container;
use RoundPartner\Deploy\Plan\Entity\Plan;
use RoundPartner\Deploy\Plan\PlanFactory;

class Server
{

    const RUN_ONCE = 1;

    protected $iterations;

    protected $container;

    private $currentIteration;

    private $sleep;

    const SLEEP_SECONDS = 60;

    public function __construct(Container $container, $iterations, $sleep = self::SLEEP_SECONDS)
    {
        $this->container = $container;
        $this->iterations = $iterations;
        $this->sleep = $sleep;
        $this->currentIteration = 0;
    }

    public function dispatch()
    {
        while ($this->runIteration()) {
            if ($this->hasNextIteration()) {
                sleep($this->sleep);
            }
        }

        return ! $this->hasNextIteration();
    }

    protected function hasNextIteration()
    {
        return $this->currentIteration < $this->iterations;
    }

    protected function runIteration()
    {
        if ($this->currentIteration >= $this->iterations) {
            return false;
        }

        $messages = $this->container->getSeq()
            ->get();

        if (null !== $messages) {
            foreach ($messages as $message) {
                $this->processMessage($message);
            }
        }

        ++$this->currentIteration;
        return true;
    }

    /**
     * @param Message $message
     *
     * @throws \Exception
     */
    protected function processMessage($message)
    {
        $plan = Plan::factory($message->body);
        $this->runPlan($plan);
        $this->container->getSeq()->delete($message->id);
    }

    /**
     * @param \RoundPartner\Deploy\Plan\Entity\Plan $planEntity
     *
     * @return bool
     */
    protected function runPlan($planEntity)
    {
        $plan = PlanFactory::createWithEntity($this->container, $planEntity);
        return $plan->deploy();
    }
}
