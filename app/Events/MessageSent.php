<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $chat;

    /**
     * Create a new event instance.
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('chat.' . $this->chat->sender_id),
            new PrivateChannel('chat.' . $this->chat->receiver_id),
        ];
    }

    /**
     * The data to broadcast.
     */
    public function broadcastWith()
    {
        return [
            'chat' => [
                'message' => $this->chat->message,
                'sender' => [
                    'id' => $this->chat->sender_id,
                    'name' => $this->chat->sender->name,
                ],
                'receiver_id' => $this->chat->receiver_id,
            ]
        ];
    }
}
