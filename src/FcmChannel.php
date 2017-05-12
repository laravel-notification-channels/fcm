<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;

//use NotificationChannels\Fcm\Events\MessageWasSent;
//use NotificationChannels\Fcm\Events\SendingMessage;

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
        $tokens = (array) $notifiable->routeNotificationForFcm();
        if (! $tokens) {
            return;
        }

        $message = $notification->toFcm($notifiable);
        if (! $message) {
            return;
        }

        $message->setRegistrationIds($tokens);

        try {
            $this->client->request('POST', '/fcm/send', [
                'body' => $message->toJson(),
            ]);
        } catch (RequestException $requestException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($requestException->getMessage());
        }
    }
}
