<?php

namespace RoundPartner\Test\Unit;

use RoundPartner\Deploy\ProcessFactory;

class ProcessFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateSetWorkingDirectory()
    {
        $process = ProcessFactory::createGitClone('address', 'directory', '/tmp/foo/bar');
        $this->assertEquals("/tmp/foo/bar", $process->getWorkingDirectory());
    }

    public function testCreateGitClone()
    {
        $process = ProcessFactory::createGitClone('address', 'directory', '/tmp');
        $this->assertEquals("'git' 'clone' 'address' 'directory'", $process->getCommandLine());
    }
    
    public function testCreateGitCheckoutMaster()
    {
        $process = ProcessFactory::createGitCheckout('master', '/tmp');
        $this->assertEquals("'git' 'checkout' 'master'", $process->getCommandLine());
    }

    public function testCreateGitCheckoutDevelop()
    {
        $process = ProcessFactory::createGitCheckout('develop', '/tmp');
        $this->assertEquals("'git' 'checkout' 'develop'", $process->getCommandLine());
    }
    
    public function testCreateGitPull()
    {
        $process = ProcessFactory::createGitPull('/tmp');
        $this->assertEquals("'git' 'pull'", $process->getCommandLine());
    }
}
