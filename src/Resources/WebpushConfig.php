<?php

namespace NotificationChannels\Fcm\Resources;

class WebpushConfig implements FcmResource
{
    /**
     * @var array|null
     */
    protected $headers;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var array|null
     */
    protected $notification;

    /**
     * @var WebpushFcmOptions|null
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
     * @return WebpushConfig
     */
    public function setHeaders(?array $headers): self
    {
        $this->headers = $headers;

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
     * @return WebpushConfig
     */
    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getNotification(): ?array
    {
        return $this->notification;
    }

    /**
     * @param array|null $notification
     * @return WebpushConfig
     */
    public function setNotification(?array $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return WebpushFcmOptions|null
     */
    public function getFcmOptions(): ?WebpushFcmOptions
    {
        return $this->fcmOptions;
    }

    /**
     * @param WebpushFcmOptions|null $fcmOptions
     * @return WebpushConfig
     */
    public function setFcmOptions(?WebpushFcmOptions $fcmOptions): self
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
            'data' => $this->getData(),
            'notification' => $this->getNotification(),
            'fcm_options' => ! is_null($this->getFcmOptions()) ? $this->getFcmOptions()->toArray() : null,
        ];
    }
}
