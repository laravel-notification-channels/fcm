<?php

namespace NotificationChannels\Fcm\Messages;

use NotificationChannels\Fcm\Notifications\FcmIosNotification;

class FcmIosMessage extends FcmMessage
{
    /**
     * @var bool Optional
     *
     * On iOS, use this field to represent content-available in the APNs payload. When a notification or message is sent and this is set to true, an inactive
     * client app is awoken. On Android, data messages wake the app by default. On Chrome, currently not supported.
     */
    protected $contentAvailable = false;

    /**
     * @var bool Optional
     *
     * Currently for iOS 10+ devices only. On iOS, use this field to represent mutable-content in the APNS payload. When a notification is sent and this is set
     * to true, the content of the notification can be modified before it is displayed, using a Notification Service app extension. This parameter will be
     * ignored for Android and web.
     */
    protected $mutableContent = false;

    /**
     * @var FcmIosNotification
     */
    protected $notification;

    /**
     * @param bool $contentAvailable
     */
    public function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;
    }

    /**
     * @param bool $mutableContent
     */
    public function setMutableContent($mutableContent)
    {
        $this->mutableContent = $mutableContent;
    }

    /**
     * @param FcmIosNotification $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return [
            'registration_ids'  => $this->registrationIds,
            'condition'         => $this->condition,
            'content_available' => $this->contentAvailable,
            'mutable_content'   => $this->mutableContent,
            'collapse_key'      => $this->collapseKey,
            'priority'          => $this->priority,
            'time_to_live'      => $this->timeToLive,
            'dry_run'           => $this->dryRun,
            'data'              => $this->data,
            'notification'      => $this->notification->toArray(),
        ];
    }
}
