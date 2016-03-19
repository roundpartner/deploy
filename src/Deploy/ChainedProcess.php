<?php

namespace RoundPartner\Deploy;

use Symfony\Component\Process\Process;

class ChainedProcess
{

    /**
     * @var Process[]
     */
    protected $chain;

    public function __construct()
    {
        $this->chain = array();
    }

    /**
     * @return ChainedProcess
     */
    public function mustRun()
    {
        foreach ($this->chain as $process) {
            $process->mustRun();
        }
        return $this;
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
}