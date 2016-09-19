<?php

namespace RoundPartner\Test\Mocks;

class Message extends \RoundPartner\Cloud\Message\Message
{

    function __construct($message)
    {
        parent::__construct($message, false);
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        return true;
    }
}
