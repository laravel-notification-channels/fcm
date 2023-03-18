<?php

namespace NotificationChannels\Fcm\Test\Resources;

use NotificationChannels\Fcm\Resources\AndroidMessagePriority;
use PHPUnit\Framework\TestCase;

class AndroidMessagePriorityTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $instance = AndroidMessagePriority::NORMAL;

        $this->assertInstanceOf(AndroidMessagePriority::class, $instance);
    }
}
