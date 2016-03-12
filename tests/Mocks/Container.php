<?php

namespace RoundPartner\Test\Mocks;

class Container extends \RoundPartner\Deploy\Container
{

    /**
     * @var Cloud
     */
    protected $cloud;

    /**
     * Container that uses test services
     */
    public function __construct()
    {
        parent::__construct('services.test');
    }

    /**
     * @return Cloud
     */
    public function getCloud()
    {
        if ($this->cloud === null) {
            $service = new CloudService();
            $this->cloud = new Cloud($service, 'secret');
        }
        return $this->cloud;
    }
}
