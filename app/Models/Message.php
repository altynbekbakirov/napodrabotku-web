<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $guarded = ['id'];

    public function scopeChat($query, $chat_id)
    {
        return $query->where('chat_id', $chat_id);
    }
}
