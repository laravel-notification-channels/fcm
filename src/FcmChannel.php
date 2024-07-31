<?php

namespace NotificationChannels\Fcm;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\SendReport;
use Psr\Log\LoggerInterface;

class FcmChannel
{
    /**
     * The maximum number of tokens we can use in a single request
     *
     * @var int
     */
    const TOKENS_PER_REQUEST = 500;

    /**
     * Logger instance
     *
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Create a new channel instance.
     *
     * @param Dispatcher $events
     * @param Messaging $client
     * @param LoggerInterface $logger
     */
    public function __construct(protected Dispatcher $events, protected Messaging $client, LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return Collection|null
     */
    public function send(mixed $notifiable, Notification $notification): ?Collection
    {
        $tokens = Arr::wrap($notifiable->routeNotificationFor('fcm', $notification));

        if (empty($tokens)) {
            return null;
        }

        $fcmMessage = $notification->toFcm($notifiable);

        return Collection::make($tokens)
            ->chunk(self::TOKENS_PER_REQUEST)
            ->map(function ($tokens) use ($fcmMessage, $notifiable, $notification) {
                try {
                    $report = ($fcmMessage->client ?? $this->client)->sendMulticast($fcmMessage, $tokens->all());
                    return $this->checkReportForFailures($notifiable, $notification, $report);
                } catch (\Exception $e) {
                    $this->logger->error('Failed to send FCM notification', ['exception' => $e]);
                    $this->dispatchFailedNotification($notifiable, $notification, $e);
                    return null;
                }
            });
    }

    /**
     * Handle the report for the notification and dispatch any failed notifications.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @param MulticastSendReport $report
     * @return MulticastSendReport
     */
    protected function checkReportForFailures(mixed $notifiable, Notification $notification, MulticastSendReport $report): MulticastSendReport
    {
        Collection::make($report->getItems())
            ->filter(fn (SendReport $report) => $report->isFailure())
            ->each(fn (SendReport $report) => $this->dispatchFailedNotification($notifiable, $notification, $report));

        return $report;
    }

    /**
     * Dispatch failed event.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @param mixed $report
     * @return void
     */
    protected function dispatchFailedNotification(mixed $notifiable, Notification $notification, $report): void
    {
        $this->events->dispatch(new NotificationFailed($notifiable, $notification, self::class, [
            'report' => $report,
        ]));
        $this->logger->info('Notification failed', ['notifiable' => $notifiable, 'notification' => $notification, 'report' => $report]);
    }
}

