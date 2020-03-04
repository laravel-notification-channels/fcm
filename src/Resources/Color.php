<?php

namespace NotificationChannels\Fcm\Resources;

class Color implements FcmResource
{
    /**
     * @var float|null
     */
    protected $red;

    /**
     * @var float|null
     */
    protected $green;

    /**
     * @var float|null
     */
    protected $blue;

    /**
     * @var float|null
     */
    protected $alpha;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }

    /**
     * @return float|null
     */
    public function getRed(): ?float
    {
        return $this->red;
    }

    /**
     * @param float|null $red
     * @return Color
     */
    public function setRed(?float $red): self
    {
        $this->red = $red;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getGreen(): ?float
    {
        return $this->green;
    }

    /**
     * @param float|null $green
     * @return Color
     */
    public function setGreen(?float $green): self
    {
        $this->green = $green;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getBlue(): ?float
    {
        return $this->blue;
    }

    /**
     * @param float|null $blue
     * @return Color
     */
    public function setBlue(?float $blue): self
    {
        $this->blue = $blue;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getAlpha(): ?float
    {
        return $this->alpha;
    }

    /**
     * @param float|null $alpha
     * @return Color
     */
    public function setAlpha(?float $alpha): self
    {
        $this->alpha = $alpha;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'red' => $this->getRed(),
            'green' => $this->getGreen(),
            'blue' => $this->getBlue(),
            'alpha' => $this->getAlpha(),
        ];
    }
}
