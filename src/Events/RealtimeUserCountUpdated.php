<?php
namespace Analytics\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeUserCountUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function broadcastOn()
    {
        return new Channel('analytics-realtime-users');
    }
}
