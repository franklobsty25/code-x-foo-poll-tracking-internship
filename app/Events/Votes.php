<?php

namespace App\Events;

use App\Models\Candidate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Votes implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $candidates;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
       // Get candidate current updates
       $this->candidates = Candidate::all();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('election');
    }

}
