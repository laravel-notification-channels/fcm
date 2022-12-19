<?php

namespace NotificationChannels\Fcm\Resources;

enum Visibility
{
    case VISIBILITY_UNSPECIFIED;
    case PRIVATE;
    case PUBLIC;
    case SECRET;
}
