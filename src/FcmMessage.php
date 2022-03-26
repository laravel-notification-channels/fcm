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
    protected ?string $name;

    /**
     * @var array|null
     */
    protected ?array $data;

    /**
     * @var Notification|null
     */
    protected ?Notification $notification;

    /**
     * @var AndroidConfig|null
     */
    protected ?AndroidConfig $android;

    /**
     * @var WebpushConfig|null
     */
    protected ?WebpushConfig $webpush;

    /**
     * @var ApnsConfig|null
     */
    protected ?ApnsConfig $apns;

    /**
     * @var FcmOptions|null
     */
    protected ?FcmOptions $fcmOptions;

    /**
     * @var string|null
     */
    protected ?string $token;

    /**
     * @var string|null
     */
    protected ?string $topic;

    /**
     * @var string|null
     */
    protected ?string $condition;

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
     * @param  string|null  $name
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
     * @param  array|null  $data
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
     * @param  Notification|null  $notification
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
     * @param  AndroidConfig|null  $android
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
     * @param  WebpushConfig|null  $webpush
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
     * @param  ApnsConfig|null  $apns
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
     * @param  FcmOptions|null  $fcmOptions
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
     * @param  string|null  $token
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
     * @param  string|null  $topic
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
     * @param  string|null  $condition
     * @return FcmMessage
     */
    public function setCondition(?string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'data' => $this->getData(),
            'notification' => $this->getNotification()?->toArray(),
            'android' => $this->getAndroid()?->toArray(),
            'webpush' =>$this->getWebpush()?->toArray(),
            'apns' => $this->getApns()?->toArray(),
            'fcm_options' => $this->getFcmOptions()?->toArray(),
            'token' => $this->getToken(),
            'topic' => $this->getTopic(),
            'condition' => $this->getCondition(),
        ];
    }

    /**
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
