<?php

namespace RoundPartner\Test\Mocks;

use RoundPartner\Cloud\CloudInterface;

class Cloud implements CloudInterface
{

    /**
     * @var CloudService
     */
    protected $client;

    /**
     * @var Queue[]
     */
    protected $queues;

    /**
     * Cloud constructor.
     *
     * @param \RoundPartner\Cloud\Service\Cloud $client
     * @param string $secret
     */
    public function __construct(\RoundPartner\Cloud\Service\Cloud $client, $secret)
    {
        $this->client = $client;
        $this->queues = array();
    }

    /**
     * @param string $queue
     *
     * @return Queue
     */
    public function queue($queue)
    {
        if (!isset($this->queues[$queue])) {
            $this->queues[$queue] = new Queue($this->client, $queue);
        }
        return $this->queues[$queue];
    }
}
