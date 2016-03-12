<?php

namespace RoundPartner\Deploy\Server;

use RoundPartner\Deploy\Container;

class ServerFactory
{

    /**
     * @param Container $container
     *
     * @return Server
     */
    public static function singleRun(Container $container)
    {
        return new Server($container, Server::RUN_ONCE);
    }

    /**
     * @param Container $container
     * @param integer $iterations
     * @param integer $sleep
     *
     * @return Server
     */
    public static function multiRun(Container $container, $iterations, $sleep = Server::SLEEP_SECONDS)
    {
        return new Server($container, $iterations, $sleep);
    }
}
