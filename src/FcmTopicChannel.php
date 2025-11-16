<?php

namespace NotificationChannels\Fcm;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\MessagingException;

class FcmTopicChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct(protected Dispatcher $events, protected Messaging $client)
    {
        //
    }

    /**
     * Send the given notification.
     */
    public function send(mixed $notifiable, Notification $notification): ?array
    {
        $message = $notification->toFcm($notifiable);

        $topic = $notifiable instanceof AnonymousNotifiable
            ? $notifiable->routeNotificationFor('fcm-topic')
            : $message->topic;

        if (empty($topic)) {
            return null;
        }

        $message->topic($topic);

        $client = $message->client ?? $this->client;

        try {
            return $client->send($message);
        } catch (MessagingException $e) {
            $this->dispatchFailedNotification($notifiable, $notification, $e);

            return null;
        }
    }

    /**
     * Dispatch failed event.
     */
    protected function dispatchFailedNotification(mixed $notifiable, Notification $notification, MessagingException $exception): void
    {
        $this->events->dispatch(new NotificationFailed($notifiable, $notification, self::class, [
            'exception' => $exception,
        ]));
    }
}
