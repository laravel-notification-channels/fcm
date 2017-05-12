<?php

namespace NotificationChannels\Fcm\Messages;

use NotificationChannels\Fcm\Notifications\FcmAndroidNotification;

class FcmAndroidMessage extends FcmMessage
{
    /**
     * @var FcmAndroidNotification
     */
    protected $notification;

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return [
            'condition'    => $this->condition,
            'collapse_key' => $this->collapseKey,
            'priority'     => $this->priority,
            'time_to_live' => $this->timeToLive,
            'dry_run'      => $this->dryRun,
            'data'         => $this->data,
            'notification' => $this->notification->toArray(),
        ];
    }
}
