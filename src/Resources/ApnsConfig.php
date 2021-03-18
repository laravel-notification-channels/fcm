<?php

namespace NotificationChannels\Fcm\Resources;

class ApnsConfig implements FcmResource
{
    /**
     * @var array|null
     */
    protected $headers;

    /**
     * @var array|null
     */
    protected $payload;

    /**
     * @var ApnsFcmOptions
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
     * @return array|null
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    /**
     * @param array|null $headers
     * @return ApnsConfig
     */
    public function setHeaders(?array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPayload(): ?array
    {
        return $this->payload;
    }

    /**
     * @param array|null $payload
     * @return ApnsConfig
     */
    public function setPayload(?array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return ApnsFcmOptions|null
     */
    public function getFcmOptions(): ?ApnsFcmOptions
    {
        return $this->fcmOptions;
    }

    /**
     * @param ApnsFcmOptions $fcmOptions
     * @return ApnsConfig
     */
    public function setFcmOptions(ApnsFcmOptions $fcmOptions): self
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
            'headers' => $this->getHeaders(),
            'payload' => $this->getPayload(),
            'fcm_options' => ! is_null($this->getFcmOptions()) ? $this->getFcmOptions()->toArray() : null,
        ];
    }
}
