<?php

namespace NotificationChannels\Fcm\Notifications;

class FcmWebNotification extends FcmNotification
{
    /**
     * @var string
     */
    protected $icon;

    /**
     * [Optional] The URL to use for the notification's icon.
     *
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'title'        => $this->title,
            'body'         => $this->body,
            'click_action' => $this->clickAction,
            'icon'         => $this->icon,
        ];
    }
}
