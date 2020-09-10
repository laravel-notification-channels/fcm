<?php

namespace NotificationChannels\Fcm\Resources;

class AndroidConfig implements FcmResource
{
    /**
     * @var string|null
     */
    protected $collapseKey;

    /**
     * @var AndroidMessagePriority|null
     */
    protected $priority;

    /**
     * @var string|null
     */
    protected $ttl;

    /**
     * @var string|null
     */
    protected $restrictedPackageName;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var AndroidNotification|null
     */
    protected $notification;

    /**
     * @var AndroidFcmOptions|null
     */
    protected $fcmOptions;

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
    public function getCollapseKey(): ?string
    {
        return $this->collapseKey;
    }

    /**
     * @param string|null $collapseKey
     * @return AndroidConfig
     */
    public function setCollapseKey(?string $collapseKey): self
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * @return AndroidMessagePriority|null
     */
    public function getPriority(): ?AndroidMessagePriority
    {
        return $this->priority;
    }

    /**
     * @param AndroidMessagePriority|null $priority
     * @return AndroidConfig
     */
    public function setPriority(?AndroidMessagePriority $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTtl(): ?string
    {
        return $this->ttl;
    }

    /**
     * @param string|null $ttl
     * @return AndroidConfig
     */
    public function setTtl(?string $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRestrictedPackageName(): ?string
    {
        return $this->restrictedPackageName;
    }

    /**
     * @param string|null $restrictedPackageName
     * @return AndroidConfig
     */
    public function setRestrictedPackageName(?string $restrictedPackageName): self
    {
        $this->restrictedPackageName = $restrictedPackageName;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     * @return AndroidConfig
     */
    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return AndroidNotification|null
     */
    public function getNotification(): ?AndroidNotification
    {
        return $this->notification;
    }

    /**
     * @param AndroidNotification|null $notification
     * @return AndroidConfig
     */
    public function setNotification(?AndroidNotification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return AndroidFcmOptions|null
     */
    public function getFcmOptions(): ?AndroidFcmOptions
    {
        return $this->fcmOptions;
    }

    /**
     * @param AndroidFcmOptions|null $fcmOptions
     * @return AndroidConfig
     */
    public function setFcmOptions(?AndroidFcmOptions $fcmOptions): self
    {
        $this->fcmOptions = $fcmOptions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'collapse_key' => $this->getCollapseKey(),
            'priority' => ! is_null($this->getPriority()) ? $this->getPriority()->label ?? $this->getPriority()->getValue() : null,
            'ttl' => $this->getTtl(),
            'restricted_package_name' => $this->getRestrictedPackageName(),
            'data' => $this->getData(),
            'notification' => ! is_null($this->getNotification()) ? $this->getNotification()->toArray() : null,
            'fcm_options' => ! is_null($this->getFcmOptions()) ? $this->getFcmOptions()->toArray() : null,
        ];
    }
}
