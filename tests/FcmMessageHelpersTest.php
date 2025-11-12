<?php

namespace NotificationChannels\Fcm\Tests;

use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use PHPUnit\Framework\TestCase;

class FcmMessageHelpersTest extends TestCase
{
    /**
     * Test that the android() helper correctly adds Android options under the 'android' key in the custom payload.
     */

    public function test_appends_android_options_into_custom()
    {
        $msg = FcmMessage::create()
            ->notification(new FcmNotification(title: 'T', body: 'B'))
            ->android(['notification' => ['channel_id' => 'ops', 'sound' => 'default']]);

        $payload = $msg->toArray();

        $this->assertArrayHasKey('android', $payload);
        $this->assertArrayHasKey('notification', $payload['android']);
        $this->assertEquals('ops', $payload['android']['notification']['channel_id']);
        $this->assertEquals('default', $payload['android']['notification']['sound']);
    }

    /**
     * Test that the ios() helper correctly adds iOS options under the 'ios' key in the custom payload.
     */
    public function test_appends_ios_options_into_custom()
    {
        $msg = FcmMessage::create()
            ->ios(['payload' => ['aps' => ['sound' => 'default']]]);

        $payload = $msg->toArray();

        $this->assertArrayHasKey('ios', $payload);
        $this->assertArrayHasKey('payload', $payload['ios']);
        $this->assertEquals('default', $payload['ios']['payload']['aps']['sound']);
    }


    /**
     * Test that using the helpers does not overwrite existing custom keys.
     * Ensures merging does not erase pre-existing custom payload data.
     */
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
