<?php

namespace NotificationChannels\Fcm\Enums;

enum Visibility
{
    case VISIBILITY_UNSPECIFIED;

    case PRIVATE;

    case PUBLIC;

    case SECRET;
}
