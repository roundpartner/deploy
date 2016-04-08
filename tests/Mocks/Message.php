<?php

namespace RoundPartner\Test\Mocks;

class Message extends \RoundPartner\Cloud\Message
{
    function __construct($message)
    {
        parent::__construct($message, false);
    }
    
    public function getBody()
    {
        return $this->message;
    }

    public function delete()
    {
        return true;
    }
}