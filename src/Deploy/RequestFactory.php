<?php

namespace Deploy;

class RequestFactory
{
    /**
     * @param string $request
     * @return Entity\Request
     */
    public static function createRequest($request)
    {
        return new Entity\Request();
    }
}