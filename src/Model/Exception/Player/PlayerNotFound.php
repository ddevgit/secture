<?php

namespace App\Model\Exception\Player;

use Exception;

class PlayerNotFound extends Exception
{
    public static function throwException()
    {
        throw new self('Player not found');
    }
}
