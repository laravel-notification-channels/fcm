<?php

namespace NotificationChannels\Fcm\Notifications;

class FcmIosNotification extends FcmNotification
{
    /**
     * @var string Optional
     *
     * The value of the badge on the home screen app icon.
     * If not specified, the badge is not changed.
     * If set to 0, the badge is removed.
     */
    protected $badge;

    /**
     * @var string Optional
     *
     * The sound to play when the device receives the notification.
     * Sound files can be in the main bundle of the client app or in the Library/Sounds folder of the app's data container.
     */
    protected $sound;

    /**
     * @var string Optional
     *
     * The key to the body string in the app's string resources to use to localize the body text to the user's current localization.
     * Corresponds to loc-key in the APNs payload.
     */
    protected $bodyLocKey;

    /**
     * @var array Optional
     *
     * Variable string values to be used in place of the format specifiers in body_loc_key to use to localize the body text to the user's current localization.
     * Corresponds to loc-args in the APNs payload.
     */
    protected $bodyLocArgs;

    /**
     * @var string Optional
     *
     * The key to the title string in the app's string resources to use to localize the title text to the user's current localization.
     * Corresponds to title-loc-key in the APNs payload.
     */
    protected $titleLocKey;

    /**
     * @var array Optional
     *
     * Variable string values to be used in place of the format specifiers in title_loc_key to use to localize the title text to the user's current localization.
     * Corresponds to title-loc-args in the APNs payload.
     */
    protected $titleLocArgs;

    /**
     * @param string $badge
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
    }

    /**
     * @param string $sound
     */
    public function setSound($sound)
    {
        $this->sound = $sound;
    }

    /**
     * @param string $bodyLocKey
     */
    public function setBodyLocKey($bodyLocKey)
    {
        $this->bodyLocKey = $bodyLocKey;
    }

    /**
     * @param array $bodyLocArgs
     */
    public function setBodyLocArgs($bodyLocArgs)
    {
        $this->bodyLocArgs = $bodyLocArgs;
    }

    /**
     * @param string $titleLocKey
     */
    public function setTitleLocKey($titleLocKey)
    {
        $this->titleLocKey = $titleLocKey;
    }

    /**
     * @param array $titleLocArgs
     */
    public function setTitleLocArgs($titleLocArgs)
    {
        $this->titleLocArgs = $titleLocArgs;
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
