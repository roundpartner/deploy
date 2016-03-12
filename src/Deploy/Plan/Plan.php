<?php

namespace RoundPartner\Deploy\Plan;

use RoundPartner\Deploy\Container;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
        if ($config === false) {
            throw new \Exception("No configuration found for {$entity->full_name}.");
        }
        $entity->clone_address = $config['repos'];
        $entity->location = $config['location'];
        $entity->directory = $config['directory'];
        $entity->command = $config['cmd'];

        $this->entity = $entity;

    }

    /**
     * @return Entity\Plan
     */
    public function getPlan()
    {
        return $this->entity;
    }

    public function dispatch()
    {
        $cloudConfig = $this->container->getConfig()->get('cloud');
        $cloud = $this->container->getCloud();
        $cloud->addMessage($cloudConfig['name'], $this->entity);

        return true;
    }

    public function deploy()
    {

        // @todo clean up all this code
        if (!file_exists($this->entity->location)) {
            if (!mkdir($this->entity->location, 0755, true)) {
                return false;
            }
        }

        $workingDirectory = $this->entity->location . '/' . $this->entity->directory;

        if (!file_exists($workingDirectory . '/.git')) {
            $cloneCommand = sprintf('git clone %s %s', $this->entity->clone_address, $this->entity->directory);
            $this->process($cloneCommand, $this->entity->location);
        } else {
            $pullCommand = sprintf('git pull');
            $this->process($pullCommand, $workingDirectory);
        }

        $checkOutCommand = 'git checkout master';
        $this->process($checkOutCommand, $workingDirectory);

        $this->process($this->entity->command, $workingDirectory);

        return true;
    }

    /**
     * @param string $command
     * @param string $workingDirectory
     *
     * @return string
     */
    private function process($command, $workingDirectory)
    {
        $this->container->getLogger()->addInfo('Running: ' . $command);
        $process = new Process($command, $workingDirectory);
        $process->setTimeout(3600);
        try {
            $process->mustRun();
        } catch(ProcessFailedException $exception) {
            $this->container->getLogger()->addError($exception->getMessage());
            return false;
        }
        $this->container->getLogger()->addInfo('Completed: ' . $command);

        $output = $process->getOutput();
        $this->container->getLogger()->addInfo('Output: ' . $output);
        return $output;
    }
}
