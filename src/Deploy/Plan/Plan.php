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
        if (array_key_exists('branch', $config)) {
            $entity->branch = $config['branch'];
        }
        if (array_key_exists('notify_email', $config)) {
            $entity->notify_email = $config['notify_email'];
        }

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

        $this->container->getLogger()->addInfo('Checking out repo');
        if (!$this->checkoutRepo($workingDirectory)) {
            return false;
        }

        $this->container->getLogger()->addInfo('Processing repo');
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
            $result = $this->runProcess(ProcessFactory::createGitCheckout('master', $workingDirectory));
            if ($result) {
                $result = $this->runProcess(ProcessFactory::createGitPull($workingDirectory));
            }
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
        $date = new \DateTime();
        $dateStamp = $date->format('Y-m-d h:i:s');
        $this->container->getLogger()->addInfo('Running Post Deployment Tasks');
        $this->container->getLogger()->addInfo('Running Pre Deployment Tasks');
        $this->maker->triggerAsync('rp_deploy', $this->entity->full_name, 'Deploying at' . $dateStamp);
    }

    private function triggerPostDeployment()
    {
        $date = new \DateTime();
        $dateStamp = $date->format('Y-m-d h:i:s');
        $this->container->getLogger()->addInfo('Running Post Deployment Tasks');
        $this->maker->triggerAsync('rp_deploy', $this->entity->full_name, 'Deployed at ' . $dateStamp);
        if ($this->entity->notify_email) {
            $subject = 'Deployment completed: ' . $this->entity->full_name;
            $text = 'Deployment of ' . $this->entity->full_name . ' was completed at ' . $dateStamp;
            $this->container->getPigeon()->sendBasicEmail($this->entity->notify_email, $this->entity->notify_email, $subject, $text);
        }
    }
}
