<?php

namespace NotificationChannels\Fcm;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\SendReport;

class FcmChannel
{
    /**
     * The maximum number of tokens we can use in a single request
     *
     * @var int
     */
    const TOKENS_PER_REQUEST = 500;

    /**
     * Create a new channel instance.
     *
     * @param  Illuminate\Contracts\Events\Dispatcher  $events
     * @param  Firebase\Contract\Messaging  $firebase
     */
    public function __construct(
        protected Dispatcher $events,
        protected Messaging $firebase
    ) {
        //
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification): void
    {
        $tokens = Arr::wrap($notifiable->routeNotificationFor('fcm', $notification));

        if (empty($tokens)) {
            return;
        }

        $fcmMessage = $notification->toFcm($notifiable);

        collect($tokens)
            ->chunk(self::TOKENS_PER_REQUEST)
            ->map(fn ($tokens) => $this->firebase->sendMulticast($fcmMessage, $tokens))
            ->map(fn (MulticastSendReport $report) => $this->handleReport($notifiable, $notification, $report));
    }

    /**
     * Handle the report for the notification and dispatch any failed notifications.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @param  Kreait\Firebase\Messaging\MulticastSendReport. $report
     * @return void
     */
    protected function handleReport($notifiable, $notification, MulticastSendReport $report)
    {
        collect($report->getItems())
            ->filter(fn (SendReport $report) => $report->isFailure())
            ->each(function (SendReport $report) use ($notifiable, $notification) {
                $this->failedNotification($notifiable, $notification, $report);
            });
    }

    /**
     * Dispatch failed event.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @param  \Kreait\Firebase\Messaging\SendReport  $report
     * @return void
     */
    protected function failedNotification($notifiable, Notification $notification, SendReport $report): void
    {
        $this->events->dispatch(new NotificationFailed(
            $notifiable,
            $notification,
            self::class,
            [
                'report' => $report,
            ]
        ));
    }
}
