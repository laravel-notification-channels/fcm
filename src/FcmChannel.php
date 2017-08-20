<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;

class FcmChannel
{
    const DEFAULT_API_URL = 'https://fcm.googleapis.com';
    const MAX_TOKEN_PER_REQUEST = 1000;

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
            $this->sendToFcm($message);
        } else {
            // Use multicast because there are multiple recipients
            $partialTokens = array_chunk($tokens, self::MAX_TOKEN_PER_REQUEST, false);
            foreach ($partialTokens as $tokens) {
                $message->setRegistrationIds($tokens);
                $this->sendToFcm($message);
            }
        }
    }

    private function sendToFcm($message) {
        try {
            $this->client->request('POST', '/fcm/send', [
                'body' => $message->toJson(),
            ]);
        } catch (RequestException $requestException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($requestException);
        }
    }
}
