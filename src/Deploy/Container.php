<?php

namespace RoundPartner\Deploy;

use RoundPartner\Cloud\Cloud;
use RoundPartner\Cloud\CloudFactory;
use RoundPartner\Conf\Service;
use RoundPartner\Maker\Maker;
use RoundPartner\Pigeon\PigeonInterface;
use RoundPartner\Seq\Seq;
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
     *
     * @throws \Exception
     */
    public function getConfig()
    {
        return $this->container->get('config');
    }

    /**
     * @return Cloud
     *
     * @throws \Exception
     */
    public function getCloud()
    {
        return $this->container->get('opencloud');
    }

    /**
     * @return \Monolog\Logger
     *
     * @throws \Exception
     */
    public function getLogger()
    {
        date_default_timezone_set('Europe/London');
        return $this->container->get('logger');
    }

    /**
     * @return Maker
     *
     * @throws \Exception
     */
    public function getMaker()
    {
        return $this->container->get('maker');
    }

    /**
     * @return PigeonInterface
     *
     * @throws \Exception
     */
    public function getPigeon()
    {
        return $this->container->get('pigeon');
    }

    /**
     * @return Runner
     *
     * @throws \Exception
     */
    public function getRunner()
    {
        return $this->container->get('runner');
    }

    /**
     * @return Seq
     *
     * @throws \Exception
     */
    public function getSeq()
    {
        return $this->container->get('seq');
    }
}
