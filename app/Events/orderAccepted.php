<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class orderAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $numberOfNotifications;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->username = $username;
        $this->message  = "{$username} Accepted your order";
    }

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return \Illuminate\Broadcasting\Channel|array
    //  */
    public function broadcastOn()
    {
        return ['order-accepted'];
    }

     /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new Channel('my-channel');
    // }

    // public function broadcastAs()
    // {
    //     return 'order-accepted';
    // }
}
