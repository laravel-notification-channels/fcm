<?php

namespace NotificationChannels\Fcm\Resources;

enum NotificationPriority
{
    case PRIORITY_UNSPECIFIED;
    case PRIORITY_MIN;
    case PRIORITY_LOW;
    case PRIORITY_DEFAULT;
    case PRIORITY_HIGH;
    case PRIORITY_MAX;
}
