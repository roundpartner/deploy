<?php

namespace RoundPartner\Test\Mocks;

class Maker
{
    /**
     * @var string
     */
    protected $key;

    /**
     * Maker constructor.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param string $event
     * @param string $value1
     * @param string $value2
     * @param string $value3
     *
     * @return bool
     */
    public function triggerAsync($event, $value1 = null, $value2 = null, $value3 = null)
    {
        return true;
    }
}
