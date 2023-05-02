<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserResetCode extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'user_email_codes';
    protected $fillable = [
        'user_id',
        'code',
    ];

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'user_id' => 10,
            'code' => 10,
        ],
    ];

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
