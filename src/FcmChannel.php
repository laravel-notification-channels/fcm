<?php

namespace NotificationChannels\Fcm;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

//use NotificationChannels\Fcm\Events\MessageWasSent;
//use NotificationChannels\Fcm\Events\SendingMessage;

class FcmChannel
{
    const DEFAULT_API_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('broadcasting.connections.fcm.url', FcmChannel::DEFAULT_API_URL),
            'headers'  => [
                'Authorization' => sprintf('key=%s', config('broadcasting.connections.fcm.key')),
                'Content-Type'  => 'application/json',
            ],
        ]);
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
        //$response = [a call to the api of your notification send]

//        if ($response->error) { // replace this by the code need to check for errors
//            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
//        }
    }
}
