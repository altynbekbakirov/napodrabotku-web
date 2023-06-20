<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickWord extends Model
{
    protected $table = 'quick_words';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
