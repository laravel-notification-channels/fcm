<?php

namespace NotificationChannels\Fcm\Resources;

class ApnsFcmOptions implements FcmResource
{
    /**
     * @var string|null
     */
    protected $analyticsLabel;

    /**
     * @var string|null
     */
    protected $image;

    /**
     * @return string|null
     */
    public function getAnalyticsLabel(): ?string
    {
        return $this->analyticsLabel;
    }

    /**
     * @param string|null $analyticsLabel
     * @return ApnsFcmOptions
     */
    public function setAnalyticsLabel(?string $analyticsLabel): self
    {
        $this->analyticsLabel = $analyticsLabel;

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
     * @return ApnsFcmOptions
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'analytics_label' => $this->getAnalyticsLabel(),
            'image' => $this->getImage(),
        ];
    }
}
