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
     * @throws \Exception
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
            $this->triggerPostDeployment('failed [repo creation]');
            return false;
        }

        $workingDirectory = $this->entity->location . '/' . $this->entity->directory;

        $this->container->getLogger()->addInfo('Checking out repo');
        if (!$this->checkoutRepo($workingDirectory)) {
            $this->triggerPostDeployment('failed [checkout]');
            return false;
        }

        $this->container->getLogger()->addInfo('Processing repo');
        if (false === $this->process($this->entity->command, $workingDirectory)) {
            $this->triggerPostDeployment('failed [processing]');
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
            $result = $this->runProcess(ProcessFactory::createGitClone(
                $this->entity->clone_address,
                $this->entity->directory,
                $this->entity->location
            ));
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
     *
     * @throws \Exception
     */
    private function process($command, $workingDirectory)
    {
        return $this->runner->run($command, $workingDirectory);
    }

    /**
     * @param Process $process
     *
     * @return bool
     *
     * @throws /Exception
     */
    private function runProcess(Process $process)
    {
        return $this->runner->runProcess($process);
    }

    private function triggerPreDeployment()
    {
        $this->container->getLogger()->addInfo('Running Pre Deployment Tasks');
    }

    /**
     * @param string $status
     *
     * @throws \Exception
     */
    private function triggerPostDeployment($status = 'successful')
    {
        $date = new \DateTime();
        $dateStamp = $date->format('Y-m-d h:i:s');
        $this->container->getLogger()->addInfo('Running Post Deployment Tasks');
        if ($this->entity->notify_email) {
            $this->container->getLogger()->addInfo('Sending email to ' . $this->entity->notify_email . ' with status of ' . $status);
            $subject = 'Deployment ' . $status . ': ' . $this->entity->full_name;
            $text = 'Deployment of ' . $this->entity->full_name . ' was ' . $status . ' at ' . $dateStamp;
            $result = $this->container->getPigeon()->sendBasicEmail($this->entity->notify_email, $this->entity->notify_email, $subject, $text);
            if (!$result) {
                $this->container->getLogger()->addInfo('Sending notification email failed');
            }
        }
    }
}
