<?php

namespace RoundPartner\Test\Mocks;

use RoundPartner\Cloud\QueueInterface;

class Queue implements QueueInterface
{

    /**
     * @var \OpenCloud\Queues\Resource\Queue
     */
    protected $service;

    /**
     * @var string
     */
    protected $name;

    /**
     * Queue constructor.
     *
     * @param CloudService $queue
     * @param string $name
     */
    public function __construct(CloudService $queue, $name)
    {
        $this->service = $queue;
        $this->name = $name;
    }

    /**
     * @param mixed $message
     * @param int $ttl
     *
     * @return bool
     */
    public function addMessage($message, $ttl = 600)
    {
        return $this->service->addMessage($this->name, $message, $ttl);
    }

    /**
     * @param integer $limit
     *
     * @return mixed[]
     *
     * @throws \Exception
     */
    public function getMessages($limit = 10)
    {
        return $this->service->getMessages($this->name, $limit);
    }
}
