<?php

namespace NotificationChannels\Fcm\Notifications;

class FcmWebNotification extends FcmNotification
{
    /**
     * @var string Optional
     *
     * The URL to use for the notification's icon.
     */
    protected $icon;

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }
}
