<?php

namespace NotificationChannels\Fcm\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FcmSentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Fcm Response 
     *
     * @var [type]
     */
    public $responses;

    /** 
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($responses)
    {
        $this->responses = $responses;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
