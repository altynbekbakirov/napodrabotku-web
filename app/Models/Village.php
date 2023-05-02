<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Village extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'villages';
    protected $fillable = [
        'nameKg',
        'nameRu',
    ];

    public function getName($lang)
    {
        if($lang == 'ru') return $this->nameRu;
        return $this->nameKg;
    }

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'nameRu' => 10,
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
