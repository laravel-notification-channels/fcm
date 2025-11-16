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

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?string $token = null,
        public ?string $topic = null,
        public ?string $condition = null,
        public ?array $data = [],
        public ?array $custom = [],
        public ?Notification $notification = null,
        public ?Messaging $client = null,
    ) {
        //
    }

    /**
     * Create a new message instance.
     */
    public static function create(...$args): static
    {
        return new static(...$args);
    }

    /**
     * Set the message name.
     */
    public function name(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the message token.
     */
    public function token(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set the message topic.
     */
    public function topic(?string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Set the message condition.
     */
    public function condition(?string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Set the message data.
     */
    public function data(?array $data): self
    {
        if (! empty(array_filter($data, fn ($value) => ! is_string($value)))) {
            throw new InvalidArgumentException('Data values must be strings.');
        }

        $this->data = $data;

        return $this;
    }

    /**
     * Set the message custom options.
     */
    public function custom(?array $custom = []): self
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * Set Aandroid specific custom options.
     */
    public function android(?array $options = []): self
    {
        $this->custom([...$this->custom, 'android' => $options]);

        return $this;
    }

    /**
     * Set APNs-specific custom options.
     */
    public function ios(?array $options = []): self
    {
        $this->custom([...$this->custom, 'apns' => $options]);

        return $this;
    }

    /**
     * Set the message notification.
     */
    public function notification(Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * Set the client to use for the message.
     */
    public function usingClient(Messaging $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get the array represenation of the message.
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'data' => $this->data,
            'token' => $this->token,
            'topic' => $this->topic,
            'condition' => $this->condition,
            'notification' => $this->notification?->toArray(),
            ...$this->custom,
        ]);
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
