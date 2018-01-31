<?php

namespace RoundPartner\Test\Providers;

use \GuzzleHttp\Psr7\Response;

class SeqProvider
{
    /**
     * @return Response[]
     */
    public static function get()
    {
        return [[[
            new Response(200, ['Content-Type' => 'application/json; charset=utf-8', 'HMAC' => 'lnhaFZ8gc3Ukqy8+Dh6Ae3dDEjbD+lL8895WMpXlR4Y='], '[{"id":1,"body":{"full_name":"symfony/yaml"}}]'),
            new Response(204, [], ''),
            new Response(200, ['Content-Type' => 'application/json; charset=utf-8', 'HMAC' => 'lnhaFZ8gc3Ukqy8+Dh6Ae3dDEjbD+lL8895WMpXlR4Y='], '[{"id":1,"body":{"full_name":"symfony/yaml"}}]'),
            new Response(204, [], ''),
            new Response(200, ['Content-Type' => 'application/json; charset=utf-8', 'HMAC' => 'lnhaFZ8gc3Ukqy8+Dh6Ae3dDEjbD+lL8895WMpXlR4Y='], '[{"id":1,"body":{"full_name":"symfony/yaml"}}]'),
            new Response(204, [], ''),
            new Response(200, ['Content-Type' => 'application/json; charset=utf-8', 'HMAC' => 'gBPtzLexSoIuVxap0j4hNLWxk24pBw6ZlpKQLwr8RVk='], '[]'),
        ]]];
    }

    /**
     * @return Response[]
     */
    public static function post()
    {
        return [
            [[new Response(204, [], '')]]
        ];
    }
}
