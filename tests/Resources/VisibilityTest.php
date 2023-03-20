<?php

namespace NotificationChannels\Fcm\Test\Resources;

use NotificationChannels\Fcm\Resources\Visibility;
use PHPUnit\Framework\TestCase;

class VisibilityTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $instance = Visibility::VISIBILITY_PUBLIC;

        $this->assertInstanceOf(Visibility::class, $instance);
    }
}
