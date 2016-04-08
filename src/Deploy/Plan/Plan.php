<?php

namespace RoundPartner\Deploy\Plan;

use RoundPartner\Deploy\ChainedProcess;
use RoundPartner\Deploy\Container;
use RoundPartner\Deploy\Exception\NoPlanException;
use RoundPartner\Deploy\ProcessFactory;
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
            throw new NoPlanException("No configuration found for {$entity->full_name}.");
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
        return $this->container->getCloud()
            ->queue($cloudConfig['name'])
            ->addMessage($this->entity);
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
            $result = $this->runProcess(ProcessFactory::createGitClone($this->entity->clone_address, $this->entity->directory, $this->entity->location));
            if (!$result) {
                return false;
            }
            $result = $this->runProcess(ProcessFactory::createGitCheckout('master', $workingDirectory));
        } else {
            $result = $this->runProcess(ProcessFactory::createGitPull($workingDirectory));
        }
        if (!$result) {
            return false;
        }

        if (false === $this->process($this->entity->command, $workingDirectory)) {
            return false;
        }

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
        $process = new Process($command, $workingDirectory);
        return $this->runProcess($process);
    }

    /**
     * @param Process $process
     *
     * @return bool
     */
    private function runProcess(Process $process)
    {
        $chain = new ChainedProcess($this->container);
        $chain->addProcess($process);
        return $chain->mustRun();

    }
}
