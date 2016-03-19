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
     * Cloud constructor.
     *
     * @param \RoundPartner\Cloud\Service\Cloud $client
     * @param string $secret
     */
    public function __construct(\RoundPartner\Cloud\Service\Cloud $client, $secret)
    {
        $this->client = $client;
    }

    /**
     * @param string $queue
     * @param mixed $message
     * @return bool
     */
    public function addMessage($queue, $message)
    {
        return $this->client->addMessage($queue, $message);
    }

    /**
     * @param string $queue
     * @param integer $limit
     *
     * @return mixed[]
     * @throws \Exception
     */
    public function getMessages($queue, $limit = 10)
    {
        return $this->client->getMessages($queue, $limit);
    }
}
