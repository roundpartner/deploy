<?php

namespace Deploy;

class RequestFactory
{
    /**
     * @param string $body
     * @return Entity\Request
     */
    public static function createRequest($body)
    {
        $request = json_decode($body);
        $entity = new Entity\Request();
        $entity->commits = $request->commits;
        $entity->head_commit = $request->head_commit;
        $entity->repository = $request->repository;
        return $entity;
    }
}