<?php

namespace RoundPartner\Deploy\Entity;

class Request
{

    /**
     * @var string
     */
    public $ref;

    /**
     * @var Commit[]
     */
    public $commits;

    /**
     * @var Commit
     */
    public $head_commit;

    /**
     * @var Repository
     */
    public $repository;
}
