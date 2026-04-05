<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Channel private user tujuan
        return new PrivateChannel('chat.' . $this->message->to_user_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message->message,
            'from_user_id' => $this->message->from_user_id,
            'to_user_id' => $this->message->to_user_id,
            'created_at' => $this->message->created_at->toDateTimeString(),
            'user' => $this->message->fromUser->name,
        ];
    }
}
