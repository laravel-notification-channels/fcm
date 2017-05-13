<?php

namespace NotificationChannels\Fcm\Notifications;

class FcmNotification
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $clickAction;

    /**
     * [Optional] The notification's title.
     *
     * This field is not visible on iOS phones and tablets.
     *
     * @param string $title
     * @return FcmNotification $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * [Optional] The notification's body text.
     *
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * [Optional]
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
     *
     * @param string $clickAction
     * @return $this
     */
    public function setClickAction($clickAction)
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getClickAction()
    {
        return $this->clickAction;
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
        ];
    }
}
