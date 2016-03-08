<?php

namespace RoundPartner\Deploy\Server;

use Cloud\Cloud;

class Server
{

    const RUN_ONCE = 1;

    protected $iterations;

    private $currentIteration;

    public function __construct($iterations)
    {
        $this->iterations = $iterations;
        $this->currentIteration = 0;
    }

    public function dispatch()
    {
        while ($this->runIteration());

        return $this->currentIteration >= $this->iterations;
    }

    protected function runIteration()
    {
        if ($this->currentIteration >= $this->iterations) {
            return false;
        }

        ++$this->currentIteration;
        return true;
    }
}
