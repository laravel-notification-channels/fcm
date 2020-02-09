<?php

namespace NotificationChannels\Fcm\Exceptions;

use Kreait\Firebase\Exception\MessagingException;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError(MessagingException $messagingException)
    {
        return new static($messagingException->getMessage());
    }
}
