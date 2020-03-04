<?php

namespace NotificationChannels\Fcm\Resources;

class AndroidFcmOptions implements FcmResource
{
    /**
     * @var string|null
     */
    protected $analyticsLabel;

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
    public function getAnalyticsLabel(): ?string
    {
        return $this->analyticsLabel;
    }

    /**
     * @param string|null $analyticsLabel
     * @return AndroidFcmOptions
     */
    public function setAnalyticsLabel(?string $analyticsLabel): self
    {
        $this->analyticsLabel = $analyticsLabel;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'analytics_label' => $this->getAnalyticsLabel(),
        ];
    }
}
