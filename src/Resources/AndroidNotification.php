<?php

namespace NotificationChannels\Fcm\Resources;

class AndroidNotification implements FcmResource
{
    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $body;

    /**
     * @var string|null
     */
    protected $icon;

    /**
     * @var string|null
     */
    protected $color;

    /**
     * @var string|null
     */
    protected $sound;

    /**
     * @var string|null
     */
    protected $tag;

    /**
     * @var string|null
     */
    protected $clickAction;

    /**
     * @var string|null
     */
    protected $bodyLocKey;

    /**
     * @var string[]|null
     */
    protected $bodyLocArgs;

    /**
     * @var string|null
     */
    protected $titleLocKey;

    /**
     * @var string[]|null
     */
    protected $titleLocArgs;

    /**
     * @var string|null
     */
    protected $channelId;

    /**
     * @var string|null
     */
    protected $ticker;

    /**
     * @var bool|null
     */
    protected $sticky;

    /**
     * @var string|null
     */
    protected $eventTime;

    /**
     * @var bool|null
     */
    protected $localOnly;

    /**
     * @var NotificationPriority|null
     */
    protected $notificationPriority;

    /**
     * @var bool|null
     */
    protected $defaultSound;

    /**
     * @var bool|null
     */
    protected $defaultVibrateTimings;

    /**
     * @var bool|null
     */
    protected $defaultLightSettings;

    /**
     * @var string[]|null
     */
    protected $vibrateTimings;

    /**
     * @var Visibility|null
     */
    protected $visibility;

    /**
     * @var int|null
     */
    protected $notificationCount;

    /**
     * @var LightSettings|null
     */
    protected $lightSettings;

    /**
     * @var string|null
     */
    protected $image;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return AndroidNotification
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     * @return AndroidNotification
     */
    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     * @return AndroidNotification
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     * @return AndroidNotification
     */
    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSound(): ?string
    {
        return $this->sound;
    }

    /**
     * @param string|null $sound
     * @return AndroidNotification
     */
    public function setSound(?string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string|null $tag
     * @return AndroidNotification
     */
    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClickAction(): ?string
    {
        return $this->clickAction;
    }

    /**
     * @param string|null $clickAction
     * @return AndroidNotification
     */
    public function setClickAction(?string $clickAction): self
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBodyLocKey(): ?string
    {
        return $this->bodyLocKey;
    }

    /**
     * @param string|null $bodyLocKey
     * @return AndroidNotification
     */
    public function setBodyLocKey(?string $bodyLocKey): self
    {
        $this->bodyLocKey = $bodyLocKey;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getBodyLocArgs(): ?array
    {
        return $this->bodyLocArgs;
    }

    /**
     * @param string[]|null $bodyLocArgs
     * @return AndroidNotification
     */
    public function setBodyLocArgs(?array $bodyLocArgs): self
    {
        $this->bodyLocArgs = $bodyLocArgs;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitleLocKey(): ?string
    {
        return $this->titleLocKey;
    }

    /**
     * @param string|null $titleLocKey
     * @return AndroidNotification
     */
    public function setTitleLocKey(?string $titleLocKey): self
    {
        $this->titleLocKey = $titleLocKey;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getTitleLocArgs(): ?array
    {
        return $this->titleLocArgs;
    }

    /**
     * @param string[]|null $titleLocArgs
     * @return AndroidNotification
     */
    public function setTitleLocArgs(?array $titleLocArgs): self
    {
        $this->titleLocArgs = $titleLocArgs;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    /**
     * @param string|null $channelId
     * @return AndroidNotification
     */
    public function setChannelId(?string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTicker(): ?string
    {
        return $this->ticker;
    }

    /**
     * @param string|null $ticker
     * @return AndroidNotification
     */
    public function setTicker(?string $ticker): self
    {
        $this->ticker = $ticker;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSticky(): ?bool
    {
        return $this->sticky;
    }

    /**
     * @param bool|null $sticky
     * @return AndroidNotification
     */
    public function setSticky(?bool $sticky): self
    {
        $this->sticky = $sticky;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEventTime(): ?string
    {
        return $this->eventTime;
    }

    /**
     * @param string|null $eventTime
     * @return AndroidNotification
     */
    public function setEventTime(?string $eventTime): self
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLocalOnly(): ?bool
    {
        return $this->localOnly;
    }

    /**
     * @param bool|null $localOnly
     * @return AndroidNotification
     */
    public function setLocalOnly(?bool $localOnly): self
    {
        $this->localOnly = $localOnly;

        return $this;
    }

    /**
     * @return NotificationPriority|null
     */
    public function getNotificationPriority(): ?NotificationPriority
    {
        return $this->notificationPriority;
    }

    /**
     * @param NotificationPriority|null $notificationPriority
     * @return AndroidNotification
     */
    public function setNotificationPriority(?NotificationPriority $notificationPriority): self
    {
        $this->notificationPriority = $notificationPriority;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDefaultSound(): ?bool
    {
        return $this->defaultSound;
    }

    /**
     * @param bool|null $defaultSound
     * @return AndroidNotification
     */
    public function setDefaultSound(?bool $defaultSound): self
    {
        $this->defaultSound = $defaultSound;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDefaultVibrateTimings(): ?bool
    {
        return $this->defaultVibrateTimings;
    }

    /**
     * @param bool|null $defaultVibrateTimings
     * @return AndroidNotification
     */
    public function setDefaultVibrateTimings(?bool $defaultVibrateTimings): self
    {
        $this->defaultVibrateTimings = $defaultVibrateTimings;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDefaultLightSettings(): ?bool
    {
        return $this->defaultLightSettings;
    }

    /**
     * @param bool|null $defaultLightSettings
     * @return AndroidNotification
     */
    public function setDefaultLightSettings(?bool $defaultLightSettings): self
    {
        $this->defaultLightSettings = $defaultLightSettings;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getVibrateTimings(): ?array
    {
        return $this->vibrateTimings;
    }

    /**
     * @param string[]|null $vibrateTimings
     * @return AndroidNotification
     */
    public function setVibrateTimings(?array $vibrateTimings): self
    {
        $this->vibrateTimings = $vibrateTimings;

        return $this;
    }

    /**
     * @return Visibility|null
     */
    public function getVisibility(): ?Visibility
    {
        return $this->visibility;
    }

    /**
     * @param Visibility|null $visibility
     * @return AndroidNotification
     */
    public function setVisibility(?Visibility $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNotificationCount(): ?int
    {
        return $this->notificationCount;
    }

    /**
     * @param int|null $notificationCount
     * @return AndroidNotification
     */
    public function setNotificationCount(?int $notificationCount): self
    {
        $this->notificationCount = $notificationCount;

        return $this;
    }

    /**
     * @return LightSettings|null
     */
    public function getLightSettings(): ?LightSettings
    {
        return $this->lightSettings;
    }

    /**
     * @param LightSettings|null $lightSettings
     * @return AndroidNotification
     */
    public function setLightSettings(?LightSettings $lightSettings): self
    {
        $this->lightSettings = $lightSettings;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return AndroidNotification
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
            'sound' => $this->getSound(),
            'tag' => $this->getTag(),
            'click_action' => $this->getClickAction(),
            'body_loc_key' => $this->getBodyLocKey(),
            'body_loc_args' => $this->getBodyLocArgs(),
            'title_loc_key' => $this->getTitleLocKey(),
            'title_loc_args' => $this->getTitleLocArgs(),
            'channel_id' => $this->getChannelId(),
            'ticker' => $this->getTicker(),
            'sticky' => $this->getSticky(),
            'event_time' => $this->getEventTime(),
            'local_only' => $this->getLocalOnly(),
            'notification_priority' => ! is_null($this->getNotificationPriority()) ? $this->getNotificationPriority()->label ?? $this->getNotificationPriority()->getValue() : null,
            'default_sound' => $this->getDefaultSound(),
            'default_vibrate_timings' => $this->getDefaultVibrateTimings(),
            'default_light_settings' => $this->getDefaultLightSettings(),
            'vibrate_timings' => $this->getVibrateTimings(),
            'visibility' => ! is_null($this->getVisibility()) ? $this->getVisibility()->label ?? $this->getVisibility()->getValue() : null,
            'notification_count' => $this->getNotificationCount(),
            //'light_setings' => ! is_null($this->getLightSettings()) ? $this->getLightSettings()->toArray() : null,
            'image' => $this->getImage(),
        ];
    }
}
