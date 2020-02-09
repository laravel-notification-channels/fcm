<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
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
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $token = $notifiable->routeNotificationFor('fcm');

        if (empty($token)) {
            throw new CouldNotSendNotification('No FCM token found for notifiable.');
        }

        // Get the message from the notification class
        $fcmMessage = $notification->toFcm($notifiable);

        if (! $fcmMessage instanceof Message) {
            throw new CouldNotSendNotification('The toFcm() method only accepts instances of ' . Message::class);
        }

        if (! is_array($token)) {
            if ($fcmMessage instanceof CloudMessage) {
                $fcmMessage = $fcmMessage->withChangedTarget('token', $token);
            }

            if ($fcmMessage instanceof FcmMessage) {
                $fcmMessage->setToken($token);
            }

            $this->sendToFcm($fcmMessage);
        } else {
            // Use multicast because there are multiple recipients
            $partialTokens = array_chunk($token, self::MAX_TOKEN_PER_REQUEST, false);
            foreach ($partialTokens as $tokens) {
                $this->sendToFcmMulticast($fcmMessage, $tokens);
            }
        }
    }

    /**
     * @param Message $fcmMessage
     * @throws CouldNotSendNotification
     */
    protected function sendToFcm(Message $fcmMessage)
    {
        try {
            FirebaseMessaging::send($fcmMessage);
        } catch (MessagingException $messagingException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($messagingException);
        }
    }

    /**
     * @param $fcmMessage
     * @param $tokens
     * @throws CouldNotSendNotification
     */
    protected function sendToFcmMulticast($fcmMessage, $tokens)
    {
        try {
            FirebaseMessaging::sendMulticast($fcmMessage, $tokens);
        } catch (MessagingException $messagingException) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($messagingException);
        }
    }
}
