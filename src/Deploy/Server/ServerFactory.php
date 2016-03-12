<?php

namespace RoundPartner\Deploy\Server;

use RoundPartner\Deploy\Container;

class ServerFactory
{

    /**
     * @param Container $container
     * @return Server
     */
    public static function singleRun(Container $container)
    {
        return new Server($container, Server::RUN_ONCE);
    }

    /**
     * @param Container $container
     * @param $iterations
     * @return Server
     */
    public static function multiRun(Container $container, $iterations)
    {
        return new Server($container, $iterations);
    }
}
