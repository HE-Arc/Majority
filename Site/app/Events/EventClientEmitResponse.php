<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventClientEmitResponse extends Event
{
    use InteractsWithSockets, SerializesModels;
	
	protected $num_response, $name_user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($response, $name)
    {
        $this->num_response = $response;
		$this->name_user = $name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
