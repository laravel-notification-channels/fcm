<?php

namespace NotificationChannels\Fcm\Exceptions;

use Exception;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\Message;

class CouldNotSendNotification extends Exception
{
    public static function serviceRespondedWithAnError(MessagingException $exception)
    {
        return new static(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }

    public static function invalidMessage()
    {
        return new static('The toFcm() method only accepts instances of ' . Message::class);
    }

    public static function invalidPropertyInArray($key)
    {
        return new static('The value of ' . $key . ' must be a string');
    }

    public static function invalidTokenValue()
    {
        return new static('The value of topic route must be a string and not empty');
    }

    public static function invalidMessageTarget($notifiable)
    {
        return new static($notifiable::class . ' notifiable has an invalid value of routeNotificationAs method');
    }
}
