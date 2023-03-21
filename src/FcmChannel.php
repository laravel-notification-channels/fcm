<?php

namespace NotificationChannels\Fcm;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MessageTarget;
use Kreait\Firebase\Messaging\Message;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use ReflectionException;
use Throwable;

class FcmChannel
{
    const MAX_TOKEN_PER_REQUEST = 500;

    /**
     * FcmChannel constructor.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     */
    public function __construct(protected Dispatcher $events)
    {
        //
    }

    /**
     * @var string|null
     */
    protected $fcmProject = null;

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array
     *
     * @throws \NotificationChannels\Fcm\Exceptions\CouldNotSendNotification
     * @throws \Kreait\Firebase\Exception\FirebaseException
     */
    public function send($notifiable, Notification $notification)
    {
        // Defaults to token for now as existing notifiable model does not have this method. This is to avoid breaking of push notification.
        // Will remove this once they are converted.
        $as = $notifiable->routeNotificationAs() ?? 'token';

        if ($as === MessageTarget::TOKEN) {
            return $this->sendToToken($notifiable, $notification);
        }

        if ($as === MessageTarget::TOPIC) {
            return $this->sendToTopic($notifiable, $notification);
        }

        throw CouldNotSendNotification::invalidMessageTarget($notifiable);
    }
    
    protected function sendToToken($notifiable, Notification $notification)
    {
        $tokens = Arr::wrap($notifiable->routeNotificationFor('fcm', $notification));

        if (empty($tokens)) {
            return [];
        }

        // Get the message from the notification class
        $fcmMessage = $notification->toFcm($notifiable);

        if (! $fcmMessage instanceof Message) {
            throw CouldNotSendNotification::invalidMessage();
        }

        $this->fcmProject = null;
        if (method_exists($notification, 'fcmProject')) {
            $this->fcmProject = $notification->fcmProject($notifiable, $fcmMessage);
        }

        $responses = [];

        try {
            if (count($tokens) === 1) {
                $responses[] = $this->sendToFcmToken($fcmMessage, $tokens[0]);
            } else {
                $partialTokens = array_chunk($tokens, self::MAX_TOKEN_PER_REQUEST, false);

                foreach ($partialTokens as $tokens) {
                    $responses[] = $this->sendToFcmTokenMulticast($fcmMessage, $tokens);
                }
            }
        } catch (MessagingException $exception) {
            $this->failedNotification($notifiable, $notification, $exception, $tokens);
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }

        return $responses;
    }

    protected function sendToTopic($notifiable, Notification $notification)
    {
        $topic = $notifiable->routeNotificationForTopic();

        if (! is_string($topic) || empty($topic)) {
            throw CouldNotSendNotification::invalidTokenValue();
        }

        // Get the message from the notification class
        $fcmMessage = $notification->toFcm($notifiable);

        try {
            $this->sendToFcmTopic($fcmMessage, $topic);
        } catch (MessagingException $exception) {
            $this->failedNotification($notifiable, $notification, $exception, $tokens);
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }

    /**
     * @return \Kreait\Firebase\Messaging
     */
    protected function messaging()
    {
        try {
            $messaging = app('firebase.manager')->project($this->fcmProject)->messaging();
        } catch (BindingResolutionException $e) {
            $messaging = app('firebase.messaging');
        } catch (ReflectionException $e) {
            $messaging = app('firebase.messaging');
        }

        return $messaging;
    }

    /**
     * @param  \Kreait\Firebase\Messaging\Message  $fcmMessage
     * @param $token
     * @return array
     *
     * @throws \Kreait\Firebase\Exception\MessagingException
     * @throws \Kreait\Firebase\Exception\FirebaseException
     */
    protected function sendToFcmToken(Message $fcmMessage, $token)
    {
        if ($fcmMessage instanceof CloudMessage) {
            $fcmMessage = $fcmMessage->withChangedTarget('token', $token);
        }

        if ($fcmMessage instanceof FcmMessage) {
            $fcmMessage->setToken($token);
        }

        return $this->messaging()->send($fcmMessage);
    }

    /**
     * @param $fcmMessage
     * @param  array  $tokens
     * @return \Kreait\Firebase\Messaging\MulticastSendReport
     *
     * @throws \Kreait\Firebase\Exception\MessagingException
     * @throws \Kreait\Firebase\Exception\FirebaseException
     */
    protected function sendToFcmTokenMulticast($fcmMessage, array $tokens)
    {
        return $this->messaging()->sendMulticast($fcmMessage, $tokens);
    }

    /**
     * @param $fcmMessage
     * @param  string  $topic
     * @return \Kreait\Firebase\Messaging\MulticastSendReport
     *
     * @throws \Kreait\Firebase\Exception\MessagingException
     * @throws \Kreait\Firebase\Exception\FirebaseException
     */
    protected function sendToFcmTopic(Message $fcmMessage, $topic)
    {
        if ($fcmMessage instanceof CloudMessage) {
            $fcmMessage = $fcmMessage->withChangedTarget('topic', $topic);
        }

        if ($fcmMessage instanceof FcmMessage) {
            $fcmMessage->setTopic($topic);
        }
        
        return $this->messaging()->send($fcmMessage);
    }
    /**
     * Dispatch failed event.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @param  \Throwable  $exception
     * @param  string|array  $token
     * @return array|null
     */
    protected function failedNotification($notifiable, Notification $notification, Throwable $exception, $token)
    {
        return $this->events->dispatch(new NotificationFailed(
            $notifiable,
            $notification,
            self::class,
            [
                'message' => $exception->getMessage(),
                'exception' => $exception,
                'token' => $token,
            ]
        ));
    }
}
