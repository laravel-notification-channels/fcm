<?php

namespace NotificationChannels\Fcm\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    public static function invalidMessage()
    {
        return new static('Invalid FCM message.');
    }

    public static function serviceRespondedWithAnError(Exception $exception)
    {
        return new static(
            "FCM responded with an error: {$exception->getMessage()}",
            $exception->getCode(),
            $exception
        );
    }
}
