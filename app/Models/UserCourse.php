<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserCourse extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'user_courses';
    protected $fillable = [
        'name',
        'organization_name',
        'end_year',
        'duration',
        'user_cv_id',
    ];

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'name' => 10,
            'organization_name' => 10,
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
