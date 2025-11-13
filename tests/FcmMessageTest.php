<?php

namespace NotificationChannels\Fcm\Test;

use Kreait\Firebase\Contract\Messaging;
use Mockery;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification;
use PHPUnit\Framework\TestCase;

class FcmMessageTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $message = new FcmMessage(name: 'name');

        $this->assertInstanceOf(FcmMessage::class, $message);

        $this->assertEquals('name', $message->name);
    }

    public function test_it_can_be_created()
    {
        $message = FcmMessage::create(name: 'name');

        $this->assertInstanceOf(FcmMessage::class, $message);

        $this->assertEquals('name', $message->name);
    }

    public function test_it_can_set_name()
    {
        $message = FcmMessage::create()->name('name');

        $this->assertEquals(['name' => 'name'], $message->toArray());
    }

    public function test_it_can_set_token()
    {
        $message = FcmMessage::create()->token('token');

        $this->assertEquals(['token' => 'token'], $message->toArray());
    }

    public function test_it_can_set_topic()
    {
        $message = FcmMessage::create()->topic('topic');

        $this->assertEquals(['topic' => 'topic'], $message->toArray());
    }

    public function test_it_can_set_condition()
    {
        $message = FcmMessage::create()->condition('condition');

        $this->assertEquals(['condition' => 'condition'], $message->toArray());
    }

    public function test_it_can_set_data()
    {
        $message = FcmMessage::create()->data(['a' => 'b']);

        $this->assertEquals(['data' => ['a' => 'b']], $message->toArray());
    }

    public function test_it_throws_exception_on_invalid_data()
    {
        $this->expectException(\InvalidArgumentException::class);

        FcmMessage::create()->data(['a' => 1]);
    }

    public function test_it_can_set_custom_attributes()
    {
        $message = FcmMessage::create()
            ->name('name')
            ->custom([
                'notification' => [
                    'title' => 'title',
                ],
            ]);

        $expected = [
            'name' => 'name',
            'notification' => [
                'title' => 'title',
            ],
        ];

        $this->assertEquals($expected, $message->toArray());
    }

    public function test_it_can_set_notification()
    {
        $notification = Notification::create()->title('title');

        $message = FcmMessage::create()->notification($notification);

        $this->assertEquals([
            'notification' => ['title' => 'title'],
        ], $message->toArray());
    }

    public function test_it_can_set_client()
    {
        $client = Mockery::mock(Messaging::class);

        $message = FcmMessage::create()->usingClient($client);

        $this->assertSame($client, $message->client);
    }

    public function test_appends_android_options_into_custom()
    {
        $msg = FcmMessage::create()
            ->notification(new Notification(title: 'T', body: 'B'))
            ->android(['notification' => ['channel_id' => 'ops', 'sound' => 'default']]);

        $payload = $msg->toArray();

        $this->assertArrayHasKey('android', $payload);
        $this->assertArrayHasKey('notification', $payload['android']);
        $this->assertEquals('ops', $payload['android']['notification']['channel_id']);
        $this->assertEquals('default', $payload['android']['notification']['sound']);
    }

    public function test_appends_ios_options_into_custom()
    {
        $msg = FcmMessage::create()
            ->ios(['payload' => ['aps' => ['sound' => 'default']]]);

        $payload = $msg->toArray();

        $this->assertArrayHasKey('apns', $payload);
        $this->assertArrayHasKey('payload', $payload['apns']);
        $this->assertEquals('default', $payload['apns']['payload']['aps']['sound']);
    }

    public function test_preserves_existing_custom_keys_when_using_helpers()
    {
        $msg = FcmMessage::create()
            ->custom(['meta' => ['a' => 1]])
            ->android(['notification' => ['color' => '#000']]);

        $payload = $msg->toArray();

        $this->assertArrayHasKey('meta', $payload);
        $this->assertEquals(1, $payload['meta']['a']);
        $this->assertEquals('#000', $payload['android']['notification']['color']);
    }
}
