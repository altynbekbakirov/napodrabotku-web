<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserVacancy extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'user_vacancy';
    protected $fillable = [
        'id',
        'user_id',
        'vacancy_id',
        'type',
        'status',
    ];

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.lastname' => 10,
            'users.surname' => 10,
            'vacancies.name' => 10,
        ],
        'joins' => [
            'users' => ['user_vacancy.user_id','users.id'],
            'vacancies' => ['user_vacancy.vacancy_id','vacancies.id'],
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id');
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
