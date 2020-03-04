<?php

namespace NotificationChannels\Fcm;

use Kreait\Firebase\Messaging\Message;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\FcmOptions;
use NotificationChannels\Fcm\Resources\Notification;
use NotificationChannels\Fcm\Resources\WebpushConfig;

class FcmMessage implements Message
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var Notification|null
     */
    protected $notification;

    /**
     * @var AndroidConfig|null
     */
    protected $android;

    /**
     * @var WebpushConfig|null
     */
    protected $webpush;

    /**
     * @var ApnsConfig|null
     */
    protected $apns;

    /**
     * @var FcmOptions|null
     */
    protected $fcmOptions;

    /**
     * @var string|null
     */
    protected $token;

    /**
     * @var string|null
     */
    protected $topic;

    /**
     * @var string|null
     */
    protected $condition;

    public static function create(): self
    {
        return new self;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return FcmMessage
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

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
     * @return FcmMessage
     */
    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return Notification|null
     */
    public function getNotification(): ?Notification
    {
        return $this->notification;
    }

    /**
     * @param Notification|null $notification
     * @return FcmMessage
     */
    public function setNotification(?Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return AndroidConfig|null
     */
    public function getAndroid(): ?AndroidConfig
    {
        return $this->android;
    }

    /**
     * @param AndroidConfig|null $android
     * @return FcmMessage
     */
    public function setAndroid(?AndroidConfig $android): self
    {
        $this->android = $android;

        return $this;
    }

    /**
     * @return WebpushConfig|null
     */
    public function getWebpush(): ?WebpushConfig
    {
        return $this->webpush;
    }

    /**
     * @param WebpushConfig|null $webpush
     * @return FcmMessage
     */
    public function setWebpush(?WebpushConfig $webpush): self
    {
        $this->webpush = $webpush;

        return $this;
    }

    /**
     * @return ApnsConfig|null
     */
    public function getApns(): ?ApnsConfig
    {
        return $this->apns;
    }

    /**
     * @param ApnsConfig|null $apns
     * @return FcmMessage
     */
    public function setApns(?ApnsConfig $apns): self
    {
        $this->apns = $apns;

        return $this;
    }

    /**
     * @return FcmOptions|null
     */
    public function getFcmOptions(): ?FcmOptions
    {
        return $this->fcmOptions;
    }

    /**
     * @param FcmOptions|null $fcmOptions
     * @return FcmMessage
     */
    public function setFcmOptions(?FcmOptions $fcmOptions): self
    {
        $this->fcmOptions = $fcmOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return FcmMessage
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTopic(): ?string
    {
        return $this->topic;
    }

    /**
     * @param string|null $topic
     * @return FcmMessage
     */
    public function setTopic(?string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCondition(): ?string
    {
        return $this->condition;
    }

    /**
     * @param string|null $condition
     * @return FcmMessage
     */
    public function setCondition(?string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'data' => $this->getData(),
            'notification' => ! is_null($this->getNotification()) ? $this->getNotification()->toArray() : null,
            'android' => ! is_null($this->getAndroid()) ? $this->getAndroid()->toArray() : null,
            'webpush' => ! is_null($this->getWebpush()) ? $this->getWebpush()->toArray() : null,
            'apns' => ! is_null($this->getApns()) ? $this->getApns()->toArray() : null,
            'fcm_options' => ! is_null($this->getFcmOptions()) ? $this->getFcmOptions()->toArray() : null,
            'token' => $this->getToken(),
            'topic' => $this->getTopic(),
            'condition' => $this->getCondition(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
