<?php

namespace RoundPartner\Test\Unit;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testGetValue()
    {
        $config = new \RoundPartner\Deploy\Config('config.example.ini');
        $config = $config->get('symfony/yaml');
        $this->assertArrayHasKey('cmd', $config);
    }
}
