<?php

namespace RoundPartner\Deploy\Plan;

use RoundPartner\Deploy\Entity\Request;
use RoundPartner\Deploy\Container;

class Plan
{

    /**
     * @var Entity\Plan
     */
    protected $entity;

    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container, $repositoryName)
    {
        $this->container = $container;
        $entity = new Entity\Plan();
        $entity->full_name = $repositoryName;

        $config = $container->getConfig()->get($entity->full_name);
        if ($config === null) {
            return;
        }
        $entity->clone_address = $config['repos'];
        $entity->location = $config['location'];
        $entity->directory = $config['directory'];
        $entity->command = $config['cmd'];

        $this->entity = $entity;

        $this->dispatch();

    }

    public function dispatch()
    {
        $cloud = $this->container->getCloud();
        $cloud->addMessage('deploy_dev', $this->entity);

        return false;
    }

    public function deploy()
    {

        // @todo clean up all this code
        if (!file_exists($this->entity->location)) {
            if (!mkdir($this->entity->location, 0755, true)) {
                return false;
            }
        }

        if (!file_exists($this->entity->location . '/' . $this->entity->directory . '/.git')) {
            $command = sprintf('cd %s && git clone %s %s', $this->entity->location, $this->entity->clone_address, $this->entity->directory);
            $this->execute($command);
        } else {
            $command = sprintf('cd %s && git pull', $this->entity->location . '/' . $this->entity->directory);
            $this->execute($command);
        }

        $command = sprintf('cd %s && %s', $this->entity->location . '/' . $this->entity->directory, $this->entity->command);
        $this->execute($command);
    }

    private function execute($command)
    {
        echo $command;
    }

}
