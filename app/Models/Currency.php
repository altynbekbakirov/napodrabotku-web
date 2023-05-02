<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Currency extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'currencies';
    protected $fillable = [
        'code',
        'name',
        'name_ru',
    ];

    public function getName($lang)
    {
        if($lang == 'ru') return $this->name_ru;
        return $this->name;
    }

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'code' => 10,
            'name' => 10,
            'name_ru' => 10,
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
}
