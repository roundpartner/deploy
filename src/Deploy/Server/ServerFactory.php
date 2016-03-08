<?php

namespace RoundPartner\Deploy\Server;

class ServerFactory
{

    public static function singleRun()
    {
        return new Server(Server::RUN_ONCE);
    }
}
