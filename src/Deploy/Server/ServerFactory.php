<?php

namespace RoundPartner\Deploy\Server;

use RoundPartner\Deploy\Container;

class ServerFactory
{

    public static function singleRun(Container $container)
    {
        return new Server($container, Server::RUN_ONCE);
    }
}
