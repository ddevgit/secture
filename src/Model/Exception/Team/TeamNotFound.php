<?php

namespace App\Model\Exception\Team;

use Exception;

class TeamNotFound extends Exception
{
    public static function throwException()
    {
        throw new self('Team not found');
    }
}
