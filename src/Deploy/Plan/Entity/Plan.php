<?php

namespace RoundPartner\Deploy\Plan\Entity;

class Plan
{
    public $full_name;
    public $location;
    public $directory;
    public $clone_address;
    public $command;
    public $branch;
    public $notify_email;

    /**
     * @param object $object
     *
     * @return Plan
     */
    public static function factory($object)
    {
        $plan = new Plan();
        foreach (get_object_vars($plan) as $key => $value) {
            if (isset($object->$key)) {
                $plan->$key = $object->$key;
            }
        }
        return $plan;
    }
}
