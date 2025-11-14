<?php

namespace NotificationChannels\Fcm\Tests;

use NotificationChannels\Fcm\FcmTopicChannel;
use NotificationChannels\Fcm\FcmMessage;
use Kreait\Firebase\Messaging\Message;
use Kreait\Firebase\Contract\Messaging;
use Illuminate\Notifications\Notification;
use PHPUnit\Framework\TestCase;
use Mockery;

class FcmTopicChannelTest extends TestCase
{
    /** @test */
    public function it_sends_a_topic_message()
    {
        $messaging = Mockery::mock(Messaging::class);
        $messaging->shouldReceive('send')
            ->once()
            ->andReturn(['name' => 'test']);

        $channel = new FcmTopicChannel($messaging);

        $msg = Mockery::mock(Message::class);
        $notification = Mockery::mock(Notification::class);
        $notification->shouldReceive('toFcm')->andReturn($msg);

        $msg->topic = 'news';

        $res = $channel->send(null, $notification);
        $this->assertEquals([['name' => 'test']], $res);
    }
}
