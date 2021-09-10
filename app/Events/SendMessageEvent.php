<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $id;
    public function __construct($message,$id)
    {
        $this->message = $message;
        $this->id = $id;
    }

    public function broadcastWith()
    {
        return [
            'id'=>$this->message->id,
            'sender_id'=>$this->message->sender_id,
            'conversation_id'=>$this->message->conversation_id,
            'message'=>$this->message->message,
            'type'=>$this->message->type,
            'created_at'=>$this->message->created_at,
            'updated_at'=>$this->message->updated_at,
        ];
    }

    public function broadcastAs()
    {
        return 'send.message';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->id);
    }
}
