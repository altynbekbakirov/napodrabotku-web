<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
//class Main extends Model implements HasMedia
{

//    use HasMediaTrait;

    protected $table = 'main';

    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'json',
        'desc' => 'json',
        'apps' => 'json',
        'copyright' => 'json',
        'socials' => 'json',
        'contacts' => 'json',
    ];

    public function getName()
    {
        $lc = app()->getLocale();
        return $this->name[$lc];
    }
    public function getDesc()
    {
        $lc = app()->getLocale();
        return $this->desc[$lc];
    }
    public function getCopyright()
    {
        $lc = app()->getLocale();
        return $this->copyright[$lc];
    }
    public function getContacts()
    {
        $lc = app()->getLocale();
        return $this->contacts[$lc];
    }
    public function getSocials()
    {
        return $this->socials;
    }
//    public function getLogo()
//    {
//        return $this->getMedia('main_logo')->last()->getUrl('logo_middle');
//    }

//    public function registerMediaCollections()
//    {
//        $this->addMediaCollection('main_logo')
//            ->registerMediaConversions(function (Media $media) {
//                $this->addMediaConversion('logo_original');
//                $this->addMediaConversion('logo_middle')
//                    ->height(60);
//                $this->addMediaConversion('logo_big')
//                    ->crop('crop-center', 60, 54);
//            });
//    }
}
