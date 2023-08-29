<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Invitation extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'invitations';
    
    protected $fillable = [
        'user_id',
        'invitation_count',
    ];

    public function getCreatedDate()
    {
        return date('d-m-Y', strtotime($this->created_at));
    }

    public function getCreatedTime()
    {
        return date('H:i', strtotime($this->created_at));
    }
}
