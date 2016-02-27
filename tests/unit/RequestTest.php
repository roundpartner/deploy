<?php

class RequestTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testGetHeaders($headers, $body)
    {
        $request = new \Deploy\Request($headers, $body);
        $this->assertInternalType('array', $request->getHeaders());
    }

    /**
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testGetBody($headers, $body)
    {
        $request = new \Deploy\Request($headers, $body);
        $this->assertInternalType('string', $request->getBody());
    }
}