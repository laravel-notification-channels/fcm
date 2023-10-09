<?php

namespace NotificationChannels\Fcm\Exceptions;

use Exception;

class InvalidPropertyException extends Exception
{
    public static function mustBeString($key)
    {
        return new static('The value of ' . $key . ' must be a string');
    }
}
