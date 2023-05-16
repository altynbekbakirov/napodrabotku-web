<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeChat($query, $chat_id)
    {
        return $query->where('chat_id', $chat_id);
    }

    public function getCreatedDateTime()
    {
        return date('d-m-Y H:i', strtotime($this->created_at));
    }

    public function getCreatedDate()
    {
        return date('d-m-Y', strtotime($this->created_at));
    }

    public function getCreatedTime()
    {
        return date('H:i', strtotime($this->created_at));
    }
}
