<?php

namespace NotificationChannels\Fcm\Resources;

abstract class FcmResource
{
    /**
     * @return static
     */
    public static function create(): static
    {
        return new static;
    }

    /**
     * Map the resource to an array.
     */
    abstract public function toArray(): array;
}