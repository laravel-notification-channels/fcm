<?php

namespace NotificationChannels\Fcm\Exceptions;

use Exception;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\Message;

class CouldNotSendNotification extends Exception
{
    public static function serviceRespondedWithAnError(MessagingException $exception): static
    {
        return new static($exception->getMessage(), $exception->getCode(), $exception);
    }

    public static function invalidMessage(): CouldNotSendNotification
    {
        return new static('The toFcm() method only accepts instances of '.Message::class);
    }
}
