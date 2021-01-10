<?php

namespace App\Events;

use App\Models\MissingPerson;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MissingPersonAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $missingPeople;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct() {
        $this->missingPeople = MissingPerson::where('status', '<>', 'found')->paginate(6);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('missing-people');
    }
}
