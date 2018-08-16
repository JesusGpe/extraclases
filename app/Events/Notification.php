<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;
class Notification implements ShouldBroadcast

{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $idextraclase;
    public $mensaje;
    
    public function __construct(User $user,$idextraclase,$mensaje)
    {
        $this->user=$user;
        $this->idextraclase=$idextraclase;
        $this->mensaje=$mensaje;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification');
    }
}
