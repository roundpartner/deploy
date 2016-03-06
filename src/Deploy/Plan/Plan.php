<?php

namespace Deploy\Plan;

use Deploy\Entity\Request;
use RoundPartner\Deploy\Container;

class Plan
{

    /**
     * @var Entity\Plan
     */
    protected $entity;

    public function __construct(Request $request, Container $container)
    {
        $entity = new Entity\Plan();
        $entity->full_name = $request->repository->full_name;

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
        return false;

        // @todo clean up all this code
        if (!file_exists($this->entity->location)) {
            if (!mkdir($this->entity->location, 0755, true)) {
                return false;
            }
        }

        if (!file_exists($this->entity->location . '/' . $this->entity->directory . '/.git')) {
            $command = sprintf('cd %s && git clone %s %s', $this->entity->location, $this->entity->clone_address, $this->entity->directory);
            exec($command);
        } else {
            $command = sprintf('cd %s && git pull', $this->entity->location . '/' . $this->entity->directory);
            exec($command);
        }

        $command = sprintf('cd %s && %s', $this->entity->location . '/' . $this->entity->directory, $this->entity->command);
        exec($command);

    }

}
