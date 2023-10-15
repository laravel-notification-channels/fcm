<?php

namespace NotificationChannels\Fcm\Resources;

abstract class FcmResource
{
    /**
     * @return static
     */
    public static function create(...$args): static
    {
        return new static(...$args);
    }

    /**
     * Map the resource to an array.
     */
    abstract public function toArray(): array;
}
