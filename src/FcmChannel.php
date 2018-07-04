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
        $fcmMessage = $notification->toFcm($notifiable);

        if (empty($fcmMessage)) {
            return;
        }

        if (count($tokens) == 1) {
            // Do not use multicast if there is only one recipient
            $fcmMessage->setTo($tokens[0]);
        } else {
            // Use multicast because there are multiple recipients
            $fcmMessage->setRegistrationIds($tokens);
        }

        try {
            $this->client->request('POST', '/fcm/send', [
                'headers' => $this->getClientHeaders($fcmMessage),
                'body' => $fcmMessage->toJson(),
            ]);
        } catch (RequestException $requestException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($requestException);
        }
    }

    /**
     * This is used to get the headers for the FCM request. We can add customization to the headers here.
     *
     * @param FcmMessage $fcmMessage
     * @return array
     */
    protected function getClientHeaders(FcmMessage $fcmMessage)
    {
        $headers = [
            'Authorization' => sprintf('key=%s', config('broadcasting.connections.fcm.key')),
            'Content-Type' => 'application/json',
        ];

        // Override the FCM key from the config
        if (! empty($fcmMessage->getFcmKey())) {
            $headers['Authorization'] = sprintf('key=%s', $fcmMessage->getFcmKey());
        }

        return $headers;
    }
}
