<?php

namespace NotificationChannels\Fcm\Resources;

class Visibility extends Enum
{
    case VISIBILITY_UNSPECIFIED;
    case PRIVATE;
    case PUBLIC;
    case SECRET;
}
