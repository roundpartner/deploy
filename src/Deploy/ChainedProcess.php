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

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->chain = array();
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    public function mustRun()
    {
        foreach ($this->chain as $process) {
            if (!$this->mustRunProcess($process)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Process $process
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function mustRunProcess(Process $process)
    {
        if (!is_dir($process->getWorkingDirectory())) {
            throw new \Exception("Working directory {$process->getWorkingDirectory()} does not exist");
        }
        $process->setTimeout(3600);
        $this->logInfo($process->getCommandLine(), 'Running');
        $process->start();
        while ($process->isRunning()) {
            usleep(250);
            $output = $process->getIncrementalOutput();
            if ($output) {
                $this->logInfo($output);
            }
            $output = $process->getIncrementalErrorOutput();
            if ($output) {
                $this->logInfo($output, 'Notice');
            }
        }
        if (!$process->isSuccessful()) {
            $this->logError(new ProcessFailedException($process));
            return false;
        }
        $output = $process->getIncrementalOutput();
        if (!$output) {
            $output = $process->getErrorOutput();
        }
        $this->logInfo($output);
        $this->logInfo($process->getCommandLine(), 'Completed');
        if (!$process->isSuccessful()) {
            return false;
        }
        return true;
    }

    /**
     * @param Process $process
     *
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
            if (!trim($line)) {
                continue;
            }
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
