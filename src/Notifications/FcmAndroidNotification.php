<?php

namespace NotificationChannels\Fcm\Notifications;

class FcmAndroidNotification extends FcmNotification
{
    /**
     * @var string Optional
     *
     * The notification's channel id (new in Android O).
     * The app must create a channel with this ID before any notification with this key is received.
     * If you don't send this key in the request, or if the channel id provided has not yet been created by your app, FCM uses the channel id specified in your app
     * manifest.
     */
    protected $androidChannelId;

    /**
     * @var string Optional
     *
     * The notification's icon.
     * Sets the notification icon to myicon for drawable resource myicon. If you don't send this key in the request, FCM displays the launcher icon specified in
     * your app manifest.
     */
    protected $icon;

    /**
     * @var string Optional
     *
     * The sound to play when the device receives the notification.
     * Supports "default" or the filename of a sound resource bundled in the app. Sound files must reside in /res/raw/.
     */
    protected $sound;

    /**
     * @var string Optional
     *
     * Identifier used to replace existing notifications in the notification drawer.
     * If not specified, each request creates a new notification.
     * If specified and a notification with the same tag is already being shown, the new notification replaces the existing one in the notification drawer.
     */
    protected $tag;

    /**
     * @var string Optional
     *
     * The notification's icon color, expressed in #rrggbb format.
     */
    protected $color;

    /**
     * @var string Optional
     *
     * The key to the body string in the app's string resources to use to localize the body text to the user's current localization.
     */
    protected $bodyLocKey;

    /**
     * @var array Optional
     *
     * Variable string values to be used in place of the format specifiers in body_loc_key to use to localize the body text to the user's current localization.
     */
    protected $bodyLocArgs;

    /**
     * @var string Optional
     *
     * The key to the title string in the app's string resources to use to localize the title text to the user's current localization.
     */
    protected $titleLocKey;

    /**
     * @var array Optional
     *
     * Variable string values to be used in place of the format specifiers in title_loc_key to use to localize the title text to the user's current localization.
     */
    protected $titleLocArgs;

    /**
     * @param string $androidChannelId
     */
    public function setAndroidChannelId($androidChannelId)
    {
        $this->androidChannelId = $androidChannelId;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @param string $sound
     */
    public function setSound($sound)
    {
        $this->sound = $sound;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
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
