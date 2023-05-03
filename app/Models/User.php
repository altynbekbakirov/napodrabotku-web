<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SearchableTrait, Notifiable;

    protected $connection = 'mysql';

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];

    protected $guarded = ['id'];

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'lastname' => 10,
            'login' => 10,
            'email' => 10,
        ],
    ];

    protected $fillable = [
        'name',
        'login',
        'email',
        'lastname',
        'surname',
        'citizen',
        'vacancy_type',
        'birth_date',
        'phone_number',
        'address',
        'type',
        'avatar',
        'active',
        'linkedin',
        'is_migrant',
        'gender',
        'region',
        'filter_region',
        'filter_district',
        'filter_activity',
        'filter_type',
        'filter_busyness',
        'filter_schedule',
        'district',
        'city',
        'street',
        'house',
        'job_type',
        'job_sphere',
        'department',
        'social_orientation',
        'contact_person_fullname',
        'contact_person_position',
        'is_product_lab_user',
    ];

    protected $casts = [
        'filter_region' => 'array',
        'filter_activity' => 'array',
        'filter_type' => 'array',
        'filter_busyness' => 'array',
        'filter_schedule' => 'array',
    ];

    protected $appends = ['age'];

    public function getFullName()
    {
        return $this->name.' '.$this->lastname;
    }

    public function getStatus()
    {
        if($this->active){
            $class = 'success';
            $status = 'активный';
        } else {
            $class = 'dark';
            $status = 'неактивный';
        }
        return '<span class="label label-inline font-weight-bold label-light-'.$class.' label-lg">'.$status.'</span>';
    }

    public function cv()
    {
        return $this->hasOne(UserCV::class, 'user_id');
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
    public function scopeOlderOrYoungerThan($query, $from, $to)
    {
        return $query->whereBetween('birth_date', [$from, $to]);
    }

    // Attributes
    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->diff(Carbon::now())->format('%y');
    }
}
