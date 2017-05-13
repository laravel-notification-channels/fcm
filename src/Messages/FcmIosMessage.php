<?php

namespace NotificationChannels\Fcm\Messages;

use NotificationChannels\Fcm\Notifications\FcmIosNotification;

class FcmIosMessage extends FcmMessage
{
    /**
     * @var bool
     */
    protected $contentAvailable = false;

    /**
     * @var bool
     */
    protected $mutableContent = false;

    /**
     * @var FcmIosNotification
     */
    protected $notification;

    /**
     * [Optional] On iOS, use this field to represent content-available in the APNs payload. When a notification or message is sent and this is set to true, an
     * inactive client app is awoken. On Android, data messages wake the app by default. On Chrome, currently not supported.
     *
     * @param bool $contentAvailable
     * @return $this
     */
    public function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;

        return $this;
    }

    /**
     * [Optional] Currently for iOS 10+ devices only. On iOS, use this field to represent mutable-content in the APNS payload. When a notification is sent and
     * this is set to true, the content of the notification can be modified before it is displayed, using a Notification Service app extension. This parameter
     * will be ignored for Android and web.
     *
     * @param bool $mutableContent
     * @return $this
     */
    public function setMutableContent($mutableContent)
    {
        $this->mutableContent = $mutableContent;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @param FcmIosNotification $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return bool
     */
    public function isContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
     * @return bool
     */
    public function isMutableContent()
    {
        return $this->mutableContent;
    }

    /**
     * @return FcmIosNotification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'to'                => $this->to,
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
