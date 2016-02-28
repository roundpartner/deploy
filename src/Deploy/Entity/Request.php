<?php

namespace Deploy\Entity;

class Request
{
    public $commits;
    public $head_commit;

    /**
     * @var Repository
     */
    public $repository;
}
