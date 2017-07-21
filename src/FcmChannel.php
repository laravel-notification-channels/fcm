<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;

class FcmChannel
{
    const DEFAULT_API_URL = 'https://fcm.googleapis.com';

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Fcm\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the token/s from the model
        $tokens = (array) $notifiable->routeNotificationForFcm();

        if (empty($tokens)) {
            return;
        }

        // Get the message from the notification class
        $message = $notification->toFcm($notifiable);

        if (empty($message)) {
            return;
        }

        if (count($tokens) == 1) {
            // Do not use multicast if there is only one recipient
            $message->setTo($tokens[0]);
        } else {
            // Use multicast because there are multiple recipients
            $message->setRegistrationIds($tokens);
        }

        try {
            $this->client->request('POST', '/fcm/send', [
                'body' => $message->toJson(),
            ]);
        } catch (RequestException $requestException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($requestException);
        }
    }
}
