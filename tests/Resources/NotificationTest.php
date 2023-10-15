<?php

namespace NotificationChannels\Fcm\Test\Resources;

use NotificationChannels\Fcm\Resources\Notification;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $message = new Notification(title: 'title');

        $this->assertInstanceOf(Notification::class, $message);

        $this->assertEquals('title', $message->title);
    }

    public function test_it_can_be_created()
    {
        $message = Notification::create(title: 'title');

        $this->assertInstanceOf(Notification::class, $message);

        $this->assertEquals('title', $message->title);
    }

    public function test_it_can_set_title()
    {
        $message = Notification::create()->title('title');

        $this->assertEquals(['title' => 'title'], $message->toArray());
    }

    public function test_it_can_set_body()
    {
        $message = Notification::create()->body('body');

        $this->assertEquals(['body' => 'body'], $message->toArray());
    }

    public function test_it_can_set_image()
    {
        $message = Notification::create()->image('image');

        $this->assertEquals(['image' => 'image'], $message->toArray());
    }
}
