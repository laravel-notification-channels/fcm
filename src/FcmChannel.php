<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\Message;
use Kreait\Laravel\Firebase\Facades\FirebaseMessaging;
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
     * @param Notification $notification
     *
     * @return array
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $tokens = (array) $notifiable->routeNotificationFor('fcm');

        if (empty($tokens)) {
            return [];
        }

        // Get the message from the notification class
        $fcmMessage = $notification->toFcm($notifiable);

        if (! $fcmMessage instanceof Message) {
            throw new CouldNotSendNotification('The toFcm() method only accepts instances of ' . Message::class);
        }

        $responses = [];

        // Use multicast because there are multiple recipients
        $partialTokens = array_chunk($tokens, self::MAX_TOKEN_PER_REQUEST, false);
        foreach ($partialTokens as $tokens) {
            $responses[] = $this->sendToFcmMulticast($fcmMessage, $tokens);
        }

        return $responses;
    }

    /**
     * @param $fcmMessage
     * @param $tokens
     *
     * @return mixed
     * @throws CouldNotSendNotification
     */
    protected function sendToFcmMulticast($fcmMessage, $tokens)
    {
        try {
            return FirebaseMessaging::sendMulticast($fcmMessage, $tokens);
        } catch (MessagingException $messagingException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($messagingException);
        }
    }
}
