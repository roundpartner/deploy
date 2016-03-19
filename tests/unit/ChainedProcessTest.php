<?php

namespace RoundPartner\Test\Unit;

use RoundPartner\Deploy\ChainedProcess;
use Symfony\Component\Process\Process;

class ChainedProcessTest extends \PHPUnit_Framework_TestCase
{
    public function testMustRun()
    {
        $changedProcess = new ChainedProcess();
        $changedProcess->addProcess(new Process('true', '/tmp'));
        $changedProcess->addProcess(new Process('true', '/tmp'));
        $changedProcess->mustRun();
    }

    public function testMustRunFails()
    {
        $changedProcess = new ChainedProcess();
        $changedProcess->addProcess(new Process('true', '/tmp'));
        $changedProcess->addProcess(new Process('false', '/tmp'));
        $this->setExpectedException('\Exception', 'The command "false" failed');
        $changedProcess->mustRun();
    }
}