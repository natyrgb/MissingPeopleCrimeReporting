<?php

namespace App\Events;

use App\Models\WantedCriminal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WantedCriminalAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $wantedCriminals;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct() {
        $this->wantedCriminals = WantedCriminal::paginate(3);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('wanted-criminals');
    }
}
