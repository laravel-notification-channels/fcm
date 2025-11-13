<?php

namespace NotificationChannels\Fcm;

use Illuminate\Support\Traits\Macroable;
use InvalidArgumentException;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\Message;
use NotificationChannels\Fcm\Resources\Notification;

class FcmMessage implements Message
{
    use Macroable;

    
    public function __construct(
        public ?string $name = null,
        public ?string $token = null,
        public ?string $topic = null,
        public ?string $condition = null,
        public ?array $data = [],
        public array $custom = [],
        public ?Notification $notification = null,
        public ?Messaging $client = null,
    ) {}


  

    public static function create(...$args): static
    {
        return new static(...$args);
    }


    public function name(?string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function token(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function topic(?string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }


    public function condition(?string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    public function data(?array $data): self
    {
        if (! empty(array_filter($data, fn($value) => ! is_string($value)))) {
            throw new InvalidArgumentException('Data values must be strings.');
        }

        $this->data = $data;

        return $this;
    }


    public function custom(?array $custom = []): self
    {
        $this->custom = $custom ?? [];

        return $this;
    }

    /**
     * Set android-specific custom options.
     */
    public function android(array $options = []): self
    {

        $this->custom([
            ...$this->custom,
            'android' => $options,
        ]);

        return $this;
    }


    /**
     * Set APNs-specific custom options for iOS.
     */
    public function ios(array $options = []): self
    {
        $this->custom([
            ...$this->custom,
            'apns' => $options,
        ]);

        return $this;
    }


    public function notification(Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    public function usingClient(Messaging $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function toArray()
    {

        $payload = array_filter([
            'name' => $this->name,
            'data' => $this->data,
            'token' => $this->token,
            'topic' => $this->topic,
            'condition' => $this->condition,
            'notification' => $this->notification?->toArray(),
            ...$this->custom,
        ]);



        return $payload;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
