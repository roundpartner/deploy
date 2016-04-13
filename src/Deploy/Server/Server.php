<?php

namespace RoundPartner\Deploy\Server;

use RoundPartner\Cloud\Message;
use RoundPartner\Cloud\Queue\Poll;
use RoundPartner\Cloud\Queue\PollFactory;
use RoundPartner\Deploy\Container;
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

        $cloudConfig = $this->container->getConfig()->get('cloud');
        $queue = $this->container->getCloud()
            ->queue($cloudConfig['name']);
        $poll = PollFactory::create($queue, $this->sleep);
        
        $message = $poll->next();
        if ($message) {
            $this->processMessage($message);
        }

        ++$this->currentIteration;
        return true;
    }

    /**
     * @param Message $message
     *
     * @throws \Exception
     */
    protected function processMessage(Message $message)
    {
        $plan = $message->getBody();
        $this->runPlan($plan);
        $message->delete();
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
