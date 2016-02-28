<?php

namespace Deploy\Plan;

use Deploy\Entity\Request;

class Plan
{

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}
