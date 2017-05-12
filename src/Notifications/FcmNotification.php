<?php

namespace NotificationChannels\Fcm\Notifications;

class FcmNotification
{
    /**
     * @var string Optional
     *
     * The notification's title.
     * This field is not visible on iOS phones and tablets.
     */
    protected $title;

    /**
     * @var string Optional
     *
     * The notification's body text.
     */
    protected $body;

    /**
     * @var string Optional
     *
     * iOS:
     * The action associated with a user click on the notification.
     * Corresponds to category in the APNs payload.
     *
     * Android:
     * The action associated with a user click on the notification.
     * If specified, an activity with a matching intent filter is launched when a user clicks on the notification.
     *
     * Web:
     * The action associated with a user click on the notification.
     * For all URL values, secure HTTPS is required.
     */
    protected $clickAction;
}
