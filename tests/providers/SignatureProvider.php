<?php

namespace Providers;

class SignatureProvider
{
    public static function signatureProvider()
    {
        return array(
            array('thisisarandomstring', '32fb3a7032b63f7e1e55e5a79678a8335d7e4676'),
            array('', 'd894ebfa4168e56bdfdd47b4ab390081e578c6e2'),
            array(false, false),
            array(null, false),
        );
    }
}