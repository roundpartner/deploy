<?php

namespace RoundPartner\Deploy;

use RoundPartner\Deploy\Entity\Commit;

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
        $entity->ref = $request->ref;
        $entity->commits = self::createCommits($request->commits);
        $entity->head_commit = self::createCommit($request->head_commit);
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

    /**
     * @param object $commits
     *
     * @return Commit[]
     */
    private static function createCommits($commits)
    {
        $entities = array();
        foreach ($commits as $commit) {
            $entities[] = self::createCommit($commit);
        }
        return $entities;
    }

    /**
     * @param $commit
     *
     * @return Commit
     */
    private static function createCommit($commit)
    {
        $entity = new Commit();
        $entity->id = $commit->id;
        return $entity;
    }
}
