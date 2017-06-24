<?php

namespace RoundPartner\Test\Mocks;

use Monolog\Logger;
use Symfony\Component\Process\Process;

class RunnerMock
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
        if ('false' === $command) {
            return false;
        }
        return true;
    }

    /**
     * @param Process $process
     *
     * @return bool
     */
    public function runProcess(Process $process)
    {
        return true;
    }
}
