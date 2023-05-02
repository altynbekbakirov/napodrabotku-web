<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserEducation extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'user_educations';
    protected $fillable = [
        'title',
        'faculty',
        'speciality',
        'type_id',
        'end_year',
        'user_cv_id',
    ];

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'title' => 10,
            'speciality' => 10,
        ],
    ];

    public function type()
    {
        return $this->belongsTo(EducationType::class, 'type_id');
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
