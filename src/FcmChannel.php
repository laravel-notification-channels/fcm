<?php

namespace NotificationChannels\Fcm;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
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
     */
    public function __construct(protected Dispatcher $events, protected Messaging $client)
    {
        //
    }

    /**
     * Send the given notification.
     */
    public function send(mixed $notifiable, Notification $notification): ?Collection
    {
        $tokens = Arr::wrap($notifiable->routeNotificationFor('fcm', $notification));

        return Collection::make($tokens)
            ->chunk(self::TOKENS_PER_REQUEST)
            ->map(fn ($tokens) => $this->sendNotifications($notifiable, $notification, $tokens))
            ->map(fn (MulticastSendReport $report) => $this->dispatchEvents($notifiable, $notification, $report));
    }

    /**
     * Send the notification with the provided tokens.
     */
    protected function sendNotifications(mixed $notifiable, Notification $notification, Collection $tokens): MulticastSendReport
    {
        $fcmMessage = $notification->toFcm($notifiable);

        $this->events->dispatch(
            new NotificationSending($notifiable, $notification, self::class)
        );

        return ($fcmMessage->client ?? $this->client)->sendMulticast($fcmMessage, $tokens->all());
    }

    /**
     * Handle the report for the notification and dispatch any failed notifications.
     */
    protected function dispatchEvents(mixed $notifiable, Notification $notification, MulticastSendReport $report): MulticastSendReport
    {
        Collection::make($report->getItems())
            ->each(function (SendReport $report) use ($notifiable, $notification) {
                $event = $report->isSuccess()
                    ? new NotificationSent($notifiable, $notification, self::class, compact('report'))
                    : new NotificationFailed($notifiable, $notification, self::class, compact('report'));

                $this->events->dispatch($event);
            });

        return $report;
    }
}
