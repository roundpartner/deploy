<?php

namespace Deploy;

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

    public static function setFile($config)
    {
        self::$instance = new Config($config);
    }

    public static function get($key)
    {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$instance->getValue($key);
    }

    public function getValue($key)
    {
        return $this->config[$key];
    }

}