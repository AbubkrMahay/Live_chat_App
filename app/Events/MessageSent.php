<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        // Log::info('MessageSent event triggered', ['message' => $message]);
    }

    public function broadcastOn()
    {
        if ($this->message->group_id) {
            return [
                new Channel('chat.group.' . $this->message->group_id),
            ];
        } else {
            return [
                new Channel('chat.' . $this->message->receiver_id),
                new Channel('chat.' . $this->message->sender_id),
            ];
        }
    }
    public function broadcastAs()
    {
        // Log::info('MessageSent broadcasting on channel', ['channel' => 'chat.' . $this->message->receiver_id]);
        return 'message.sent';
    }
    public function broadcastWith()
    {
        return [
            'message' => [
                'content' => $this->message->content,
                'sender' => [
                    'id' => $this->message->sender_id,
                    'name' => $this->message->sender->name,
                ],
                'timestamp' => $this->message->created_at->toDateTimeString(),
            ],
        ];
    }
}
