<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Busyness extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'bussynesses';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'name_ru',
    ];

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'name' => 10,
        ],
    ];

    public function getName($lang)
    {
        if($lang == 'ru') return $this->name_ru;
        return $this->name;
    }

    public function busynesses(){
        return Busyness::all();
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
