<?php

namespace NotificationChannels\Fcm\Test;

use Illuminate\Contracts\Events\Dispatcher;
use Mockery;
use NotificationChannels\Fcm\FcmChannel;
use PHPUnit\Framework\TestCase;

class FcmChannelTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $events = Mockery::mock(Dispatcher::class);

        $channel = new FcmChannel($events);

        $this->assertInstanceOf(FcmChannel::class, $channel);
    }
}
