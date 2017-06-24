<?php

namespace RoundPartner\Deploy;

use RoundPartner\Cloud\Cloud;
use RoundPartner\Cloud\CloudFactory;
use RoundPartner\Conf\Service;
use RoundPartner\Maker\Maker;
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

        $auth = Service::get('opencloud');
        $cloud = CloudFactory::create($auth['username'], $auth['key'], $auth['secret']);
        $this->container->set('opencloud', $cloud);

        $makerClass = $this->container->getDefinition('maker')->getClass();
        $makerConfig = Service::get('ifttt');
        $maker = new $makerClass($makerConfig['key']);
        $this->container->set('maker', $maker);
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

    /**
     * @return Maker
     */
    public function getMaker()
    {
        return $this->container->get('maker');
    }

    /**
     * @return Runner
     */
    public function getRunner()
    {
        return $this->container->get('runner');
    }
}
