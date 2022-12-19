<?php

namespace NotificationChannels\Fcm\Resources;

enum Visibility
{
    case IS_UNSPECIFIED;
    case IS_PRIVATE;
    case IS_PUBLIC;
    case IS_SECRET;
}
