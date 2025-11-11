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
     * Extra android notification options (channel_id, sound, color, etc.).
     */
    protected ?array $androidNotification = null;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?string $token = null,
        public ?string $topic = null,
        public ?string $condition = null,
        public ?array $data = [],
        public array $custom = [],
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
     * Set the message data, or throw exception if data is not an array of strings.
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
     * Set additional custom message data.
     */
    public function custom(?array $custom): self
    {
        $this->custom = $custom ?? [];

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
     * Set the message Firebase Messaging client instance.
     */
    public function usingClient(Messaging $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Helper to define android.notification options.
     *
     * Example:
     * ->androidNotification([
     *     'channel_id' => 'alertas-operativas',
     *     'sound' => 'default',
     * ])
     */
    public function androidNotification(array $options): self
    {
        $this->androidNotification = $options;

        return $this;
    }

    public function toArray()
    {
        // payload base
        $payload = array_filter([
            'name' => $this->name,
            'data' => $this->data,
            'token' => $this->token,
            'topic' => $this->topic,
            'condition' => $this->condition,
            'notification' => $this->notification?->toArray(),
            ...$this->custom,
        ]);

        // si usamos el helper, lo metemos en android.notification
        if (! empty($this->androidNotification)) {
            $payload['android'] = $payload['android'] ?? [];
            $payload['android']['notification'] = array_merge(
                $payload['android']['notification'] ?? [],
                $this->androidNotification
            );
        }

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
