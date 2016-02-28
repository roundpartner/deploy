<?php

namespace Deploy\Plan;

use Deploy\Config;
use Deploy\Entity\Request;

class Plan
{

    /**
     * @var Entity\Plan
     */
    protected $entity;

    public function __construct(Request $request)
    {
        $entity = new Entity\Plan();
        $entity->full_name = $request->repository->full_name;

        $config = Config::get($entity->full_name);
        $entity->command = $config->cmd;

        $this->entity = $entity;
    }

}
