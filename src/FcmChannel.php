<?php

namespace NotificationChannels\Fcm;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\Message;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\SendReport;
use ReflectionException;
use Throwable;

class FcmChannel
{
    const TOKENS_PER_REQUEST = 500;

    /**
     * Create a new channel instance.
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
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification): void
    {
        $tokens = Arr::wrap($notifiable->routeNotificationFor('fcm', $notification));

        if (empty($tokens)) {
            return;
        }

        // Get the message from the notification class
        $fcmMessage = $notification->toFcm($notifiable);

        $this->fcmProject = null;
        if (method_exists($notification, 'fcmProject')) {
            $this->fcmProject = $notification->fcmProject($notifiable, $fcmMessage);
        }

        collect($tokens)
          ->chunk(self::TOKENS_PER_REQUEST)
          ->map(fn ($tokens) => $this->messaging()->sendMulticast($fcmMessage, $tokens))
          ->map(function (MulticastSendReport $report) {
                collect($report->getItems())
                    ->filter(fn (SendReport $report) => $report->isFailure())
                    ->each(function (SendReport $report) {
                        $this->failedNotification($notifiable, $notification, $report);
                    });
          });
    }

    /**
     * Get the messaging instance.
     */
    protected function messaging(): Messaging
    {
        try {
            return app('firebase.manager')->project($this->fcmProject)->messaging();
        } catch (BindingResolutionException | ReflectionException $e) {
            return app('firebase.messaging');
        }
    }

    /**
     * Dispatch failed event.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @param \Kreait\Firebase\Messaging\SendReport $report
     */
    protected function failedNotification($notifiable, Notification $notification, SendReport $report, $token): void
    {
        $this->events->dispatch(new NotificationFailed(
            $notifiable,
            $notification,
            self::class,
            [
                'message' => $report->message(),
                'exception' => $report->error(),
                'token' => $report->target()->value(),
            ]
        ));
    }
}
