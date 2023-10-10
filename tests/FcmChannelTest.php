<?php

namespace NotificationChannels\Fcm\Test;

use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\MessageTarget;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\SendReport;
use Mockery;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use PHPUnit\Framework\TestCase;

class FcmChannelTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function test_it_can_be_instantiated()
    {
        $events = Mockery::mock(Dispatcher::class);
        $firebase = Mockery::mock(Messaging::class);

        $channel = new FcmChannel($events, $firebase);

        $this->assertInstanceOf(FcmChannel::class, $channel);
    }

    public function test_it_can_send_notifications()
    {
        $events = Mockery::mock(Dispatcher::class);
        $events->shouldNotReceive('dispatch');

        $firebase = Mockery::mock(Messaging::class);
        $firebase->shouldReceive('sendMulticast')
            ->with(Mockery::any(), ['token'])
            ->andReturn(MulticastSendReport::withItems([
                SendReport::success($this->target(), []),
            ]));

        $channel = new FcmChannel($events, $firebase);

        $result = $channel->send(new DummyNotifiable, new DummyNotification);

        $this->assertNull($result);
    }

    public function test_it_can_dispatch_events()
    {
        $events = Mockery::mock(Dispatcher::class);
        $events->shouldReceive('dispatch')->once();

        $firebase = Mockery::mock(Messaging::class);
        $firebase->shouldReceive('sendMulticast')
            ->with(Mockery::any(), ['token'])
            ->andReturn(MulticastSendReport::withItems([
                SendReport::failure($this->target(), new Exception),
            ]));

        $channel = new FcmChannel($events, $firebase);

        $result = $channel->send(new DummyNotifiable, new DummyNotification);

        $this->assertNull($result);
    }

    protected function target()
    {
        return MessageTarget::with(MessageTarget::TOKEN, 'token');
    }
}

class DummyNotification extends Notification
{
    public function toFcm($notifiable)
    {
        return new FcmMessage;
    }
}

class DummyNotifiable
{
    use Notifiable;

    public function routeNotificationForFcm($notification)
    {
        return ['token'];
    }
}
