<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserExperience  extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'user_experiences';
    protected $fillable = [
        'job_title',
        'start_date',
        'end_date',
        'organization_name',
        'description',
        'user_cv_id',
    ];

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'job_title' => 10,
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
