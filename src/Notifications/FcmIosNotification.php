<?php

namespace NotificationChannels\Fcm\Notifications;

class FcmIosNotification extends FcmNotification
{
    /**
     * @var string
     */
    protected $badge;

    /**
     * @var string
     */
    protected $sound;

    /**
     * @var string
     */
    protected $bodyLocKey;

    /**
     * @var array
     */
    protected $bodyLocArgs;

    /**
     * @var string
     */
    protected $titleLocKey;

    /**
     * @var array
     */
    protected $titleLocArgs;

    /**
     * [Optional] The value of the badge on the home screen app icon.
     * If not specified, the badge is not changed.
     * If set to 0, the badge is removed.
     *
     * @param string $badge
     * @return $this
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * [Optional] The sound to play when the device receives the notification.
     * Sound files can be in the main bundle of the client app or in the Library/Sounds folder of the app's data container.
     *
     * @param string $sound
     * @return $this
     */
    public function setSound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * [Optional] The key to the body string in the app's string resources to use to localize the body text to the user's current localization.
     * Corresponds to loc-key in the APNs payload.
     *
     * @param string $bodyLocKey
     * @return $this
     */
    public function setBodyLocKey($bodyLocKey)
    {
        $this->bodyLocKey = $bodyLocKey;

        return $this;
    }

    /**
     * [Optional] Variable string values to be used in place of the format specifiers in body_loc_key to use to localize the body text to the user's current localization.
     * Corresponds to loc-args in the APNs payload.
     *
     * @param array $bodyLocArgs
     * @return $this
     */
    public function setBodyLocArgs($bodyLocArgs)
    {
        $this->bodyLocArgs = $bodyLocArgs;

        return $this;
    }

    /**
     * [Optional] The key to the title string in the app's string resources to use to localize the title text to the user's current localization.
     * Corresponds to title-loc-key in the APNs payload.
     *
     * @param string $titleLocKey
     * @return $this
     */
    public function setTitleLocKey($titleLocKey)
    {
        $this->titleLocKey = $titleLocKey;

        return $this;
    }

    /**
     * [Optional] Variable string values to be used in place of the format specifiers in title_loc_key to use to localize the title text to the user's current localization.
     * Corresponds to title-loc-args in the APNs payload.
     *
     * @param array $titleLocArgs
     * @return $this
     */
    public function setTitleLocArgs($titleLocArgs)
    {
        $this->titleLocArgs = $titleLocArgs;

        return $this;
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @return string
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * @return string
     */
    public function getBodyLocKey()
    {
        return $this->bodyLocKey;
    }

    /**
     * @return array
     */
    public function getBodyLocArgs()
    {
        return $this->bodyLocArgs;
    }

    /**
     * @return string
     */
    public function getTitleLocKey()
    {
        return $this->titleLocKey;
    }

    /**
     * @return array
     */
    public function getTitleLocArgs()
    {
        return $this->titleLocArgs;
    }

    public function toArray()
    {
        return [
            'title'          => $this->title,
            'body'           => $this->body,
            'badge'          => $this->badge,
            'click_action'   => $this->clickAction,
            'sound'          => $this->sound,
            'body_loc_key'   => $this->bodyLocKey,
            'body_loc_args'  => $this->bodyLocArgs,
            'title_loc_key'  => $this->titleLocKey,
            'title_loc_args' => $this->titleLocArgs,
        ];
    }
}
