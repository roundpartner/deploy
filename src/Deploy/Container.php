<?php

namespace RoundPartner\Deploy;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use RoundPartner\Cloud\Cloud;
use RoundPartner\Cloud\CloudFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class Container
 *
 * @package RoundPartner\Deploy
 */
class Container
{

    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * Container constructor.
     *
     * @param string $config
     */
    public function __construct($config = 'services')
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config/'));
        $loader->load($config . '.yml');
        $this->container = $container;

        $auth = require __DIR__ . '/../../vendor/rp/conf/auth.php';
        $cloud = CloudFactory::create($auth['opencloud']['username'], $auth['opencloud']['key'], $auth['opencloud']['secret']);
        $this->container->set('opencloud', $cloud);

        $log = $this->container->get('logger');
        $log->pushHandler(new StreamHandler('/tmp/deploy.log', Logger::INFO));
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->container->get('config');
    }

    /**
     * @return Cloud
     */
    public function getCloud()
    {
        return $this->container->get('opencloud');
    }

    /**
     * @return \Monolog\Logger
     */
    public function getLogger()
    {
        date_default_timezone_set('Europe/London');
        return $this->container->get('logger');
    }
}
