<?php

class ConfigTest extends PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        \Deploy\Config::setFile('config.example.ini');
        $config = \Deploy\Config::get('symfony/yaml');
        $this->assertArrayHasKey('cmd', $config);
    }

}