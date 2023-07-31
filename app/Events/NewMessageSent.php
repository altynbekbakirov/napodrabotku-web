<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user_id;
    public $chat_id;
    public $avatar;
    public $username;
    public $created_at;

    public function __construct($message, $user_id, $chat_id, $avatar, $username, $created_at)
    {
        $this->message = $message;
        $this->user_id = $user_id;
        $this->chat_id = $chat_id;
        $this->avatar = $avatar;
        $this->username = $username;
        $this->created_at = $created_at;
    }

    public function broadcastOn()
    {
        return ['chat'];
    }

    public function broadcastAs()
    {
        return 'new-message-sent';
    }
}
