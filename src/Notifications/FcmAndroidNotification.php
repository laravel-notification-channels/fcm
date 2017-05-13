<?php

namespace NotificationChannels\Fcm\Notifications;

class FcmAndroidNotification extends FcmNotification
{
    /**
     * @var string
     */
    protected $androidChannelId;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var string
     */
    protected $sound;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var string
     */
    protected $color;

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
     * [Optional] The notification's channel id (new in Android O).
     * The app must create a channel with this ID before any notification with this key is received.
     * If you don't send this key in the request, or if the channel id provided has not yet been created by your app, FCM uses the channel id specified in your app
     * manifest.
     *
     * @param string $androidChannelId
     * @return $this
     */
    public function setAndroidChannelId($androidChannelId)
    {
        $this->androidChannelId = $androidChannelId;

        return $this;
    }

    /**
     * [Optional] The notification's icon.
     * Sets the notification icon to myicon for drawable resource myicon. If you don't send this key in the request, FCM displays the launcher icon specified in
     * your app manifest.
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
     * [Optional] The sound to play when the device receives the notification.
     * Supports "default" or the filename of a sound resource bundled in the app. Sound files must reside in /res/raw/.
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
     * [Optional] Identifier used to replace existing notifications in the notification drawer.
     * If not specified, each request creates a new notification.
     * If specified and a notification with the same tag is already being shown, the new notification replaces the existing one in the notification drawer.
     *
     * @param string $tag
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * [Optional] The notification's icon color, expressed in #rrggbb format.
     *
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * [Optional] The key to the body string in the app's string resources to use to localize the body text to the user's current localization.
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
     * [Optional] The key to the title string in the app's string resources to use to localize the title text to the user's current localization.
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
     * [Optional] Variable string values to be used in place of the format specifiers in body_loc_key to use to localize the body text to the user's current
     * localization.
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
     * [Optional] Variable string values to be used in place of the format specifiers in title_loc_key to use to localize the title text to the user's current
     * localization.
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
    public function getAndroidChannelId()
    {
        return $this->androidChannelId;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
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
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
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
            'title'              => $this->title,
            'body'               => $this->body,
            'click_action'       => $this->clickAction,
            'android_channel_id' => $this->androidChannelId,
            'icon'               => $this->icon,
            'sound'              => $this->sound,
            'tag'                => $this->tag,
            'color'              => $this->color,
            'body_loc_key'       => $this->bodyLocKey,
            'body_loc_args'      => $this->bodyLocArgs,
            'title_loc_key'      => $this->titleLocKey,
            'title_loc_args'     => $this->titleLocArgs,
        ];
    }
}
