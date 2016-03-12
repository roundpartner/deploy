<?php

namespace RoundPartner\Deploy;

class Config
{

    /**
     * @var Config
     */
    protected static $instance;

    protected $config;

    protected $configFile;

    protected $configModifiedTime;

    public function __construct($configFile = 'config.ini')
    {
        $this->configFile = $configFile;

    }

    public function get($key)
    {
        $config = $this->getConfig($this->configFile);
        return $config[$key];
    }

    /**
     * @param $configFile
     * @return array
     */
    protected function getConfig($configFile)
    {
        $config = dirname(__FILE__) . '/../../config/' . $configFile;
        $configModifiedTime = filemtime($config);
        if ($configModifiedTime > $this->configModifiedTime) {
            $this->config = parse_ini_file($config, true);
        }
        return $this->config;
    }
}
