<?php

namespace NotificationChannels\Fcm\Test;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging as MessagingClient;
use Mockery;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use NotificationChannels\Fcm\FcmChannel;
use PHPUnit\Framework\TestCase;

class FcmChannelTest extends TestCase
{
    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @var MessagingClient
     */
    protected $client;

    /**
     * @var FcmChannel
     */
    protected $channel;

    public function setUp(): void
    {
        parent::setUp();

        $this->events = Mockery::mock(Dispatcher::class);
        $this->client = Mockery::mock(MessagingClient::class);

        $this->channel = new FcmChannel($this->client, $this->events);
    }

    public function test_it_can_send_a_notification()
    {
        $this->client->shouldReceive('send')
            ->once()
            ->andReturn(['status' => true]);

        $response = $this->channel->send(new TestNotifiableModel(), new TestNotification());
        $this->assertNotEmpty($response);
    }

    public function test_it_can_send_a_notification_to_multiple_tokens()
    {
        $this->events->shouldNotReceive('dispatch');
        $this->client->shouldReceive('sendMulticast')
            ->once()
            ->andReturn(\Kreait\Firebase\Messaging\MulticastSendReport::withItems([]));

        $response = $this->channel->send(new TestNotifiableModelWithMultipleTokens(), new TestNotification());
        $this->assertNotEmpty($response);
    }

    public function test_it_does_not_send_notification_when_notifiable_does_not_have_a_token()
    {
        $this->client->shouldNotReceive('send');

        $response = $this->channel->send(new TestNotifiableModelWithoutToken(), new TestNotification());
        $this->assertEmpty($response);
    }

    public function test_it_should_throw_exception_on_failure()
    {
        $this->events->shouldReceive('dispatch')->once();

        $this->client->shouldReceive('send')
            ->once()
            ->andThrow(\Exception::class);

        $this->expectException(CouldNotSendNotification::class);

        $this->channel->send(new TestNotifiableModel(), new TestNotification());
    }
}

class TestNotifiableModel
{
    use Notifiable;

    public function routeNotificationForFcm($notification)
    {
        return 'random_token';
    }
}

class TestNotifiableModelWithMultipleTokens
{
    use Notifiable;

    public function routeNotificationForFcm($notification)
    {
        return ['random_token', 'another_token'];
    }
}

class TestNotifiableModelWithoutToken
{
    use Notifiable;

    public function routeNotificationForFcm($notification)
    {
        return false;
    }
}

class TestNotification extends Notification
{
    public function toFcm($notifiable)
    {
        return \NotificationChannels\Fcm\FcmMessage::create()
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Message title')
                ->setBody('Sample message body')
            );
    }
}
