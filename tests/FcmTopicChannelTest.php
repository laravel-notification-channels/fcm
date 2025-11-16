<?php

namespace NotificationChannels\Fcm\Test;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\Messaging\MessagingError;
use Kreait\Firebase\Exception\MessagingException;
use Mockery;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\FcmTopicChannel;
use PHPUnit\Framework\TestCase;

class FcmTopicChannelTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_it_can_be_instantiated(): void
    {
        $events = Mockery::mock(Dispatcher::class);
        $firebase = Mockery::mock(Messaging::class);

        $channel = new FcmTopicChannel($events, $firebase);

        $this->assertInstanceOf(FcmTopicChannel::class, $channel);
    }

    public function test_it_can_send_notifications_with_on_demand_anonymous_notifiable(): void
    {
        $events = Mockery::mock(Dispatcher::class);
        $events->shouldNotReceive('dispatch');

        $response = ['response' => 'array'];

        $firebase = Mockery::mock(Messaging::class);
        $firebase->shouldReceive('send')
            ->once()
            ->with(Mockery::on(fn ($message) => $message instanceof FcmMessage && $message->topic === 'news'))
            ->andReturn($response);

        $channel = new FcmTopicChannel($events, $firebase);

        $notifiable = new AnonymousNotifiable;
        $notifiable->route('fcm-topic', 'news');

        $result = $channel->send($notifiable, new TopicNotification);

        $this->assertEquals($response, $result);
    }

    public function test_it_can_send_notifications_with_topic_on_message(): void
    {
        $events = Mockery::mock(Dispatcher::class);
        $events->shouldNotReceive('dispatch');

        $response = ['response' => 'array'];

        $firebase = Mockery::mock(Messaging::class);
        $firebase->shouldReceive('send')
            ->once()
            ->with(Mockery::on(fn ($message) => $message instanceof FcmMessage && $message->topic === 'sports'))
            ->andReturn($response);

        $channel = new FcmTopicChannel($events, $firebase);

        $notifiable = new TopicNotifiableWithMessage;

        $result = $channel->send($notifiable, new TopicNotificationWithTopic);

        $this->assertEquals($response, $result);
    }

    public function test_it_can_send_notifications_with_custom_client(): void
    {
        $events = Mockery::mock(Dispatcher::class);
        $events->shouldNotReceive('dispatch');

        $defaultFirebase = Mockery::mock(Messaging::class);
        $defaultFirebase->shouldNotReceive('send');

        $response = ['response' => 'array'];

        $customFirebase = Mockery::mock(Messaging::class);
        $customFirebase->shouldReceive('send')
            ->once()
            ->with(Mockery::on(fn ($message) => $message instanceof FcmMessage && $message->topic === 'breaking-news'))
            ->andReturn($response);

        $channel = new FcmTopicChannel($events, $defaultFirebase);

        $notifiable = new AnonymousNotifiable;
        $notifiable->route('fcm-topic', 'breaking-news');

        $result = $channel->send($notifiable, new TopicNotificationWithCustomClient($customFirebase));

        $this->assertEquals($response, $result);
    }

    public function test_it_dispatches_notification_failed_event_when_exception_is_thrown(): void
    {
        $events = Mockery::mock(Dispatcher::class);
        $events->shouldReceive('dispatch')
            ->once()
            ->with(Mockery::on(function ($event) {
                return $event instanceof NotificationFailed
                    && $event->channel === FcmTopicChannel::class
                    && isset($event->data['exception'])
                    && $event->data['exception'] instanceof MessagingException;
            }));

        $firebase = Mockery::mock(Messaging::class);
        $firebase->shouldReceive('send')
            ->once()
            ->andThrow(new MessagingError('Test error'));

        $channel = new FcmTopicChannel($events, $firebase);

        $notifiable = new AnonymousNotifiable;
        $notifiable->route('fcm-topic', 'error-topic');

        $result = $channel->send($notifiable, new TopicNotification);

        $this->assertNull($result);
    }

    public function test_it_returns_null_when_no_topic_is_provided(): void
    {
        $events = Mockery::mock(Dispatcher::class);
        $events->shouldNotReceive('dispatch');

        $firebase = Mockery::mock(Messaging::class);
        $firebase->shouldNotReceive('send');

        $channel = new FcmTopicChannel($events, $firebase);

        // Not routing to fcm-topic
        $notifiable = new AnonymousNotifiable;

        $result = $channel->send($notifiable, new TopicNotification);

        $this->assertNull($result);
    }
}

class TopicNotification extends Notification
{
    public function toFcm($notifiable)
    {
        return FcmMessage::create();
    }
}

class TopicNotificationWithTopic extends Notification
{
    public function toFcm($notifiable)
    {
        return FcmMessage::create()->topic('sports');
    }
}

class TopicNotificationWithCustomClient extends Notification
{
    public function __construct(public Messaging $client)
    {
        //
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()->usingClient($this->client);
    }
}

class TopicNotifiableWithMessage
{
    public function routeNotificationFor($channel, $notification = null)
    {
        // This simulates a model-based notifiable that doesn't use AnonymousNotifiable
        // The topic will come from the message itself
        return null;
    }
}
