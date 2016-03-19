<?php

namespace RoundPartner\Deploy;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class ProcessFactory
{
    const GIT_PREFIX = 'git';
    const GIT_CLONE = 'clone';
    const GIT_CHECKOUT = 'checkout';
    const GIT_PULL = 'pull';

    /**
     * @param string $repository
     * @param string $target
     * @param string $workingDirectory
     *
     * @return Process
     */
    public static function createGitClone($repository, $target, $workingDirectory)
    {
        $builder = self::createBuilder($workingDirectory);
        return $builder
            ->setPrefix(self::GIT_PREFIX)
            ->setArguments([self::GIT_CLONE, $repository, $target])
            ->getProcess();
    }

    /**
     * @param string $branch
     * @param string $workingDirectory
     *
     * @return Process
     */
    public static function createGitCheckout($branch, $workingDirectory)
    {
        $builder = self::createBuilder($workingDirectory);
        return $builder
            ->setPrefix(self::GIT_PREFIX)
            ->setArguments([self::GIT_CHECKOUT, $branch])
            ->getProcess();
    }

    /**
     * @param string $workingDirectory
     *
     * @return Process
     */
    public static function createGitPull($workingDirectory)
    {
        $builder = self::createBuilder($workingDirectory);
        return $builder
            ->setPrefix(self::GIT_PREFIX)
            ->setArguments([self::GIT_PULL])
            ->getProcess();
    }

    /**
     * @param string $workingDirectory
     *
     * @return Process
     */
    private static function createBuilder($workingDirectory)
    {
        $builder = new ProcessBuilder();
        return $builder
            ->setWorkingDirectory($workingDirectory);
    }
}
