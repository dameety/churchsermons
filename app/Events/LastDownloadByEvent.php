<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class LastDownloadByEvent
{
    use InteractsWithSockets, SerializesModels;

    public $sermon;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sermon)
    {
        $this->sermon = $sermon;
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
