<?php

namespace NotificationChannels\Fcm;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\Message;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;

class FcmTopicChannel
{
    public function __construct(protected Messaging $client) {}

    public function send($notifiable, Notification $notification)
    {
        $msg = $notification->toFcm($notifiable);

        if (! $msg instanceof Message) {
            throw CouldNotSendNotification::invalidMessage();
        }

        if (empty($msg->topic)) {
            throw CouldNotSendNotification::serviceRespondedWithAnError(
                new \Exception('Topic is required.')
            );
        }

        try {
            $response = $this->client->send($msg);
        } catch (\Throwable $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e);
        }

        return [$response];
    }
}
