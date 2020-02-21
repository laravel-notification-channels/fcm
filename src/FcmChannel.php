<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use Psr\Http\Message\ResponseInterface;

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
     * @return ResponseInterface[]
     * @throws \NotificationChannels\Fcm\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $responses = [];
        // Get the token/s from the model
        if (! $notifiable->routeNotificationFor('fcm')) {
            return;
        }
        $tokens = (array) $notifiable->routeNotificationFor('fcm');

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
            $fcmMessage->setTo(reset($tokens));
            $responses[] = $this->sendToFcm($fcmMessage);
        } else {
            // Use multicast because there are multiple recipients
            $partialTokens = array_chunk($tokens, self::MAX_TOKEN_PER_REQUEST, false);
            foreach ($partialTokens as $tokens) {
                $fcmMessage->setRegistrationIds($tokens);
                $responses[] = $this->sendToFcm($fcmMessage);
            }
        }

        return $responses;
    }

    /**
     * @param $fcmMessage
     * @return ResponseInterface
     * @throws CouldNotSendNotification
     */
    protected function sendToFcm($fcmMessage)
    {
        try {
            return $this->client->request('POST', '/fcm/send', [
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
