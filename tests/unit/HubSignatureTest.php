<?php

class HubSignatureTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testVerify($headers, $body, $secret)
    {
        $request = new \Deploy\Request($headers, $body);
        $hubSignature = new \Deploy\HubSignature($secret);

        $this->assertTrue($hubSignature->verify($request));
    }

}