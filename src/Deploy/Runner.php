<?php

namespace RoundPartner\Deploy;

use Monolog\Logger;
use Symfony\Component\Process\Process;

class Runner
{

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
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
        $chain = new ChainedProcess($this->logger);
        $chain->addProcess($process);
        return $chain->mustRun();
    }
}