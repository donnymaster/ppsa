<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Message details
     *
     * @var array
     */
    public $message;

    /**
     * Chat name
     *
     * @var string
     */
    public $chat_name;

    /**
     * User id
     *
     * @var int
     */
    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $message, string $chat_name, int $userId)
    {
        $this->message = $message;
        $this->chat_name = $chat_name;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->chat_name);
    }
}
