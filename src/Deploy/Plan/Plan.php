<?php

namespace RoundPartner\Deploy\Plan;

use RoundPartner\Deploy\Container;
use RoundPartner\Deploy\ProcessFactory;
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
            $this->runProcess(ProcessFactory::createGitClone($this->entity->clone_address, $this->entity->directory, $workingDirectory));
            $result = $this->runProcess(ProcessFactory::createGitCheckout('master', $workingDirectory));
        } else {
            $result = $this->runProcess(ProcessFactory::createGitPull($workingDirectory));
        }
        if (false === $result) {
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
     * @return bool|string
     */
    private function runProcess(Process $process)
    {
        $command = $process->getCommandLine();
        $process->setTimeout(3600);
        $this->logInfo($command, 'Running');
        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            $this->logError($exception->getMessage());
            return false;
        }
        $this->logInfo($command, 'Completed');

        $output = $process->getOutput();
        if (!$output) {
            $output = $process->getErrorOutput();
        }
        $this->logInfo($output);
        return $output;
    }

    /**
     * @param string $output
     * @param string $prefix
     */
    private function logInfo($output, $prefix = 'Output')
    {
        foreach (explode("\n", $output) as $line) {
            $this->container->getLogger()->addInfo($prefix . ': ' . $line);
        }
    }

    /**
     * @param string $output
     * @param string $prefix
     */
    private function logError($output, $prefix = 'Error')
    {
        foreach (explode("\n", $output) as $line) {
            $this->container->getLogger()->addError($prefix . ': ' . $line);
        }
    }
}
