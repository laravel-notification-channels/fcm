<?php

namespace NotificationChannels\Fcm\Resources;

class LightSettings implements FcmResource
{
    /**
     * @var Color
     */
    protected $color;

    /**
     * @var string|null
     */
    protected $lightOnDuration;

    /**
     * @var string|null
     */
    protected $lightOffDuration;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }

    /**
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * @param Color $color
     * @return LightSettings
     */
    public function setColor(Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLightOnDuration(): ?string
    {
        return $this->lightOnDuration;
    }

    /**
     * @param string|null $lightOnDuration
     * @return LightSettings
     */
    public function setLightOnDuration(?string $lightOnDuration): self
    {
        $this->lightOnDuration = $lightOnDuration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLightOffDuration(): ?string
    {
        return $this->lightOffDuration;
    }

    /**
     * @param string|null $lightOffDuration
     * @return LightSettings
     */
    public function setLightOffDuration(?string $lightOffDuration): self
    {
        $this->lightOffDuration = $lightOffDuration;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'color' => ! is_null($this->getColor()) ? $this->getColor()->toArray() : null,
            'light_on_duration' => $this->getLightOnDuration(),
            'light_off_duration' => $this->getLightOffDuration(),
        ];
    }
}
