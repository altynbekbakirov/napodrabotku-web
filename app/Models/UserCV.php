<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserCV  extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'user_cvs';
    protected $fillable = [
        'experience_year',
        'job_title',
        'user_id',
        'attachment',
    ];

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'job_title' => 10,
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
