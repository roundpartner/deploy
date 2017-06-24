<?php

namespace RoundPartner\Test\Unit;

use RoundPartner\Deploy\ChainedProcess;
use RoundPartner\Test\Mocks\Container;
use Symfony\Component\Process\Process;

class ChainedProcessTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ChainedProcess
     */
    protected $chainedProcess;

    public function setUp()
    {
        $container = new Container();
        $this->chainedProcess = new ChainedProcess($container->getLogger());
        $this->chainedProcess->addProcess(new Process('true', '/tmp'));
    }

    public function testMustRun()
    {
        $changedProcess = $this->chainedProcess;
        $changedProcess->addProcess(new Process('true', '/tmp'));
        $this->assertTrue($changedProcess->mustRun());
    }

    public function testMustRunFails()
    {
        $changedProcess = $this->chainedProcess;
        $changedProcess->addProcess(new Process('false', '/tmp'));
        $this->assertFalse($changedProcess->mustRun());
    }

    public function testMustRunWrongDirectory()
    {
        $changedProcess = $this->chainedProcess;
        $changedProcess->addProcess(new Process('true', '/tmp/foo/bar'));
        $this->setExpectedException('\Exception', 'Working directory /tmp/foo/bar does not exist');
        $changedProcess->mustRun();
    }
}
