<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventMasterEmitNewQuestion extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
	
	public $new_question

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($question)
    {
        $this->new_question = $question;
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
