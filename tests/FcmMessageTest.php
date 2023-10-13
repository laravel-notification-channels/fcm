<?php

namespace NotificationChannels\Fcm\Test;

use Kreait\Firebase\Contract\Messaging;
use Mockery;
use NotificationChannels\Fcm\FcmMessage;
use PHPUnit\Framework\TestCase;

class FcmMessageTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $message = FcmMessage::create();

        $this->assertInstanceOf(FcmMessage::class, $message);
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

    public function test_it_can_set_client()
    {
        $client = Mockery::mock(Messaging::class);

        $message = FcmMessage::create()->usingClient($client);

        $this->assertSame($client, $message->client);
    }
}
