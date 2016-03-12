<?php

namespace RoundPartner\Deploy;

class Config
{

    /**
     * @var Config
     */
    protected static $instance;

    protected $config;

    public function __construct($configFile = 'config.ini')
    {
        $config = dirname(__FILE__) . '/../../config/' . $configFile;
        $this->config = parse_ini_file($config, true);
    }

    public function get($key)
    {
        return $this->config[$key];
    }
}
