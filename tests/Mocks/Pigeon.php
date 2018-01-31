<?php

namespace RoundPartner\Test\Mocks;

use RoundPartner\Pigeon\PigeonInterface;

class Pigeon implements PigeonInterface
{
    public function sendEmail($email)
    {
        return false;
    }

    public function sendBasicEmail($from, $to, $subject, $text, $html = '')
    {
        return true;
    }

    public function sendTrackedEmail($from, $to, $subject, $text, $html = '')
    {
        return false;
    }

    public function sendEmailTemplate($to, $template, $params)
    {
        return false;
    }

    public function template($template, $params)
    {
        return false;
    }
}
