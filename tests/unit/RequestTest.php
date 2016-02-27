<?php

class RequestTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param array[] $headers
     * @param string $body
     *
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testGetHeaders($headers, $body)
    {
        $request = new \Deploy\Request($headers, $body);
        $this->assertInternalType('array', $request->getHeaders());
    }

    /**
     * @param array[] $headers
     * @param string $body
     *
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testGetRawBody($headers, $body)
    {
        $request = new \Deploy\Request($headers, $body);
        $this->assertInternalType('string', $request->getRawBody());
    }

    /**
     * @param array[] $headers
     * @param string $body
     *
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testGetBody($headers, $body)
    {
        $request = new \Deploy\Request($headers, $body);
        $this->assertInstanceOf('Deploy\Entity\Request', $request->getBody());
    }

    /**
     * @param array[] $headers
     * @param string $body
     *
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testGetBodyHasCommits($headers, $body)
    {
        $request = new \Deploy\Request($headers, $body);
        $body = $request->getBody();
        $this->assertNotEmpty($body->commits);
    }

    /**
     * @param array[] $headers
     * @param string $body
     * @param string $secret
     *
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testVerify($headers, $body, $secret)
    {
        $request = new \Deploy\Request($headers, $body);
        $this->assertTrue($request->verify($secret));
    }
}