<?php

namespace RoundPartner\Deploy;

use Symfony\Component\Process\Process;

class Runner
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $command
     * @param string $workingDirectory
     *
     * @return bool
     */
    public function run($command, $workingDirectory)
    {
        $process = new Process($command, $workingDirectory);
        return $this->runProcess($process);
    }

    /**
     * @param Process $process
     *
     * @return bool
     */
    public function runProcess(Process $process)
    {
        $chain = new ChainedProcess($this->container);
        $chain->addProcess($process);
        return $chain->mustRun();
    }
}
