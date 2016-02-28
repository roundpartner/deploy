<?php

namespace Deploy\Plan;

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
        $this->entity = $entity;
    }

}
