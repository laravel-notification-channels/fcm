<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\Message;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;

class FcmChannel
{
    const MAX_TOKEN_PER_REQUEST = 500;

    /**
     * @var Client
     */
    protected $client;

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
            $this->sendToFcm($fcmMessage);
        } else {
            // Use multicast because there are multiple recipients
            $partialTokens = array_chunk($tokens, self::MAX_TOKEN_PER_REQUEST, false);
            foreach ($partialTokens as $tokens) {
                $fcmMessage->setRegistrationIds($tokens);
                $this->sendToFcm($fcmMessage);
            }
        }
    }

    protected function sendToFcm(Message $fcmMessage)
    {

    }
}
