<?php

namespace RoundPartner\Deploy;

class RequestFactory
{

    /**
     * @param string $json
     *
     * @return Entity\Request
     */
    public static function parse($json)
    {
        $request = json_decode($json);
        return self::createRequest($request);
    }

    /**
     * @param object $request
     *
     * @return Entity\Request
     */
    public static function createRequest($request)
    {
        $entity = new Entity\Request();
        $entity->commits = $request->commits;
        $entity->head_commit = $request->head_commit;
        $entity->repository = self::createRepository($request->repository);
        return $entity;
    }

    /**
     * @param object $repository
     *
     * @return Entity\Repository
     */
    private static function createRepository($repository)
    {
        $entity = new Entity\Repository();
        $entity->id = $repository->id;
        $entity->name = $repository->name;
        $entity->full_name = $repository->full_name;
        $entity->owner = $repository->owner;
        return $entity;
    }
}
