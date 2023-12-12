<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewInvitationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $company_id;
    public $vacancy_id;
    public $type;

    public function __construct(
        $user_id,
        $company_id,
        $vacancy_id,
        $type)
    {
        $this->user_id = $user_id;
        $this->company_id = $company_id;
        $this->vacancy_id = $vacancy_id;
        $this->type = $type;
    }

    public function broadcastOn()
    {
        return ['chat'];
    }

    public function broadcastAs()
    {
        return 'new-invitation-sent';
    }
}
