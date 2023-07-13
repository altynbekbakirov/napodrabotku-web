<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserCompany extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'user_company';
    protected $fillable = [
        'id',
        'user_id',
        'company_id',
        'type',
        'status',
    ];

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.lastname' => 10,
            'users.surname' => 10,
        ],
        'joins' => [
            'users' => ['user_vacancy.user_id','users.id'],
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function usersList()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function getCreatedDate()
    {
        return date('d-m-Y', strtotime($this->created_at));
    }

    public function getCreatedTime()
    {
        return date('H:i', strtotime($this->created_at));
    }

    //    Scopes
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
