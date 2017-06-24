<?php

namespace RoundPartner\Deploy\Plan;

use RoundPartner\Deploy\Container;
use RoundPartner\Deploy\Exception\NoPlanException;
use RoundPartner\Deploy\ProcessFactory;
use RoundPartner\Deploy\Runner;
use Symfony\Component\Process\Process;
use RoundPartner\Maker\Maker;

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

    /**
     * @var Maker
     */
    protected $maker;

    /**
     * @var Runner
     */
    protected $runner;

    /**
     * @param Container $container
     * @param string $repositoryName
     * @param Maker $maker
     *
     * @throws NoPlanException
     */
    public function __construct(Container $container, $repositoryName, $maker)
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

        $this->maker = $maker;

        $this->runner = $this->container->getRunner();
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
        $this->triggerPreDeployment();

        if (!$this->createRepoFolder($this->entity->location)) {
            return false;
        }

        $workingDirectory = $this->entity->location . '/' . $this->entity->directory;

        if (!$this->checkoutRepo($workingDirectory)) {
            return false;
        }

        if (false === $this->process($this->entity->command, $workingDirectory)) {
            return false;
        }

        $this->triggerPostDeployment();

        return true;
    }

    /**
     * @return bool
     */
    public function checkoutRepo()
    {
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
        return $result;
    }

    /**
     * @param string $location
     *
     * @return bool
     */
    public function createRepoFolder($location)
    {
        if (file_exists($location)) {
            return true;
        }
        if (mkdir($location, 0755, true)) {
            return true;
        }
        return false;
    }

    /**
     * @param string $command
     * @param string $workingDirectory
     *
     * @return bool
     */
    private function process($command, $workingDirectory)
    {
        return $this->runner->run($command, $workingDirectory);
    }

    /**
     * @param Process $process
     *
     * @return bool
     */
    private function runProcess(Process $process)
    {
        return $this->runner->runProcess($process);
    }

    private function triggerPreDeployment()
    {
        $this->maker->triggerAsync('rp_deploy', $this->entity->full_name, 'Deploying');
    }

    private function triggerPostDeployment()
    {
        $this->maker->triggerAsync('rp_deploy', $this->entity->full_name, 'Deployed');
    }
}
