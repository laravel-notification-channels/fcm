<?php

namespace NotificationChannels\Fcm\Test;

use Illuminate\Support\Str;
use NotificationChannels\Fcm\FcmMessage;
use PHPUnit\Framework\TestCase;

class FcmMessageTest extends TestCase
{
    /** @test */
    public function testCanGetCorrectArrayWhenHasToken()
    {
        $fcmMsg = new FcmMessage();
        $array = $fcmMsg->setName('fake name')
            ->setData([])
            ->setToken(Str::uuid()->toString())
            ->toArray();

        $this->assertArrayHasKey('token', $array);
        $this->assertArrayNotHasKey('topic', $array);
        $this->assertArrayNotHasKey('condition', $array);
    }

    /** @test */
    public function testCanGetCorrectArrayWhenHasCondition()
    {
        $fcmMsg = new FcmMessage();
        $array = $fcmMsg->setName('fake name')
            ->setData([])
            ->setCondition('fake condition')
            ->toArray();

        $this->assertArrayHasKey('condition', $array);
        $this->assertArrayNotHasKey('topic', $array);
        $this->assertArrayNotHasKey('token', $array);
    }

    /** @test */
    public function testCanGetCorrectArrayWhenNotHasToken()
    {
        $fcmMsg = new FcmMessage();
        $array = $fcmMsg->setName('fake name')
            ->setData([])
            ->setTopic('fake topic')
            ->toArray();

        $this->assertArrayHasKey('topic', $array);
        $this->assertArrayNotHasKey('token', $array);
        $this->assertArrayNotHasKey('condition', $array);
    }
}
