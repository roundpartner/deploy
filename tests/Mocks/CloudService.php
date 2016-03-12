<?php

namespace RoundPartner\Test\Mocks;

use RoundPartner\Cloud\Service\Cloud;

class CloudService extends Cloud
{

    /**
     * @var array
     */
    protected $messages;

    public function __construct()
    {
        $this->messages = array();
    }

    /**
     * @param string $queue
     * @param mixed $message
     * @return bool
     */
    public function addMessage($queue, $message)
    {
        if (!array_key_exists($queue, $this->messages)) {
            $this->messages[$queue] = array();
        }
        $this->messages[$queue][] = $message;
        return true;
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
        $response = array();
        if (!array_key_exists($queue, $this->messages)) {
            return $response;
        }
        return array_splice($this->messages[$queue], 0, $limit);
    }
}
