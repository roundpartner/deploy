<?php

namespace RoundPartner\Test\Mocks;

use RoundPartner\Cloud\QueueInterface;
use OpenCloud\Queues\Resource\Claim;

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
     * @param int $limit
     * @param int $grace
     * @param int ttl
     *
     * @return mixed[]
     *
     * @throws \Exception
     */
    public function getMessages($limit = Claim::LIMIT_DEFAULT, $grace = CLAIM::GRACE_DEFAULT, $ttl = CLAIM::TTL_DEFAULT)
    {
        return $this->service->getMessages($this->name, $limit);
    }
}
