<?php

namespace NotificationChannels\Fcm\Test\Resources;

use NotificationChannels\Fcm\Resources\NotificationPriority;
use PHPUnit\Framework\TestCase;

class NotificationPriorityTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $instance = NotificationPriority::PRIORITY_UNSPECIFIED;

        $this->assertInstanceOf(NotificationPriority::class, $instance);
    }
}
