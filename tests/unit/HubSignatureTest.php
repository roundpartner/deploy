<?php

namespace RoundPartner\Test\Unit;

class HubSignatureTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider \RoundPartner\Test\Providers\RequestProvider::requestProvider()
     */
    public function testVerify($headers, $body, $secret)
    {
        $request = new \RoundPartner\Deploy\Request($headers, $body);
        $hubSignature = new \RoundPartner\Deploy\HubSignature($secret);

        $this->assertTrue($hubSignature->verify($request));
    }
}
