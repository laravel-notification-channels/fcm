<?php

namespace NotificationChannels\Fcm\Resources;

class Notification extends FcmResource
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        public ?string $title = null,
        public ?string $body = null,
        public ?string $image = null
    ) {
        //
    }

    /**
     * Set the notification title.
     */
    public function title(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the notification body.
     */
    public function body(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Set the notification image.
     */
    public function image(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Map the resource to an array.
     */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->image,
        ]);
    }
}
