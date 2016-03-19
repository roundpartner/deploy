<?php

namespace RoundPartner\Deploy;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ChainedProcess
{
    
    /**
     * @var Container
     */
    protected $container;
    
    /**
     * @var Process[]
     */
    protected $chain;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->chain = array();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function mustRun()
    {
        foreach ($this->chain as $process) {
            if (!is_dir($process->getWorkingDirectory())) {
                throw new \Exception("Working directory {$process->getWorkingDirectory()} does not exist");
                return false;
            }
            $this->logInfo($process->getCommandLine(), 'Running');
            try {
                $process->mustRun();
            } catch (ProcessFailedException $exception) {
                $this->logError($exception->getMessage());
                return false;
            }
            $this->logInfo($process->getCommandLine(), 'Completed');
            $output = $process->getOutput();
            if (!$output) {
                $output = $process->getErrorOutput();
            }
            $this->logInfo($output);
            if (!$process->isSuccessful()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Process $process
     * @return ChainedProcess
     */
    public function addProcess(Process $process)
    {
        $this->chain[] = $process;
        return $this;
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
