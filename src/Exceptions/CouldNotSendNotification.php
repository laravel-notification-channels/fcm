<?php

namespace NotificationChannels\Fcm\Exceptions;

use GuzzleHttp\Exception\RequestException;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError(RequestException $requestException)
    {
        return new static($requestException->getMessage());
    }
}
