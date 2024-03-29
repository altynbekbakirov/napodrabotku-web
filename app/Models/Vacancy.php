<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Vacancy extends Model
{
    use SearchableTrait;

    protected $connection = 'mysql';

    protected $table = 'vacancies';

    protected $fillable = [
        'name',
        'title',
        'description',
        'salary',
        'salary_from',
        'salary_to',
        'salary_period',
        'busyness_id',
        'schedule_id',
        'job_type_id',
        'is_disability_person_vacancy',
        'vacancy_type_id',
        'phone_number',
        'address',
        'region',
        'district',
        'city',
        'street',
        'house',
        'lat',
        'lonq',
        'metro',
        'currency',
        'company_id',
        'country_id',
        'is_active',
        'period',
        'pay_period',
        'experience',
        'opportunity_id',
        'opportunity_type_id',
        'internship_language_id',
        'opportunity_duration_id',
        'age_from',
        'age_to',
        'recommendation_letter_type_id',
        'is_product_lab_vacancy',
        'vacancy_link',
        'deadline',
        'status',
        'status_update_at',
        'metro_colors'
    ];

    protected $searchable = [
        'columns' => [
            'id' => 10,
            'name' => 10,
        ],
    ];

    protected $casts = [
        'metro' => 'array',
        'metro_colors' => 'array'
    ];

    protected $appends = ['salary_final'];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function vacancytypes()
    {
        return VacancyType::all();
    }

    public function vacancytype()
    {
        return $this->belongsTo(VacancyType::class, 'vacancy_type_id');
    }

    public function jobtypes()
    {
        return JobType::all();
    }

    public function jobtype()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    public function busynesses()
    {
        return Busyness::all();
    }


    public function busyness()
    {
        return $this->belongsTo(Busyness::class, 'busyness_id');
    }

    public function schedules()
    {
        return Schedule::all();
    }


    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function regions()
    {
        return Region::all();
    }

    public function getRegion()
    {
        return $this->belongsTo(Region::class, 'region');
    }
    public function getDistrict()
    {
        return $this->belongsTo(District::class, 'district');
    }

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class, 'opportunity_id');
    }

    public function opportunity_type()
    {
        return $this->belongsTo(OpportunityType::class, 'opportunity_type_id');
    }

    public function internship_language()
    {
        return $this->belongsTo(IntershipLanguage::class, 'internship_language_id');
    }

    public function opportunity_duration()
    {
        return $this->belongsTo(OpportunityDuration::class, 'opportunity_duration_id');
    }

    public function recommendation_letter_type()
    {
        return $this->belongsTo(RecommendationLetterType::class, 'recommendation_letter_type_id');
    }

    public function getcurrency()
    {
        return $this->belongsTo(Currency::class, 'currency');
    }

    public function getCreatedDate()
    {
        return date('d-m-Y', strtotime($this->created_at));
    }

    public function getCreatedTime()
    {
        return date('H:i', strtotime($this->created_at));
    }

    public function getStatusPlain()
    {
        if($this->status == 'not_published'){
            $status = 'На модерации';
        } elseif ($this->status == 'active') {
            $status = 'Активно';
        } elseif ($this->status == 'denied') {
            $status = 'Отклонено';
        } elseif ($this->status == 'archived') {
            $status = 'В архиве';
        } else {
            $status = 'Удалено';
        }
        return $status;
    }

    public function getSalaryFinalAttribute()
    {
        $salary = '';

        if ($this->salary_from) {
            if ($this->salary_to) {
                $salary = $this->salary_from . '-' . $this->salary_to;
            } else {
                $salary = 'от ' . $this->salary_from;
            }
        } else {
            if ($this->salary_to) {
                $salary = 'до ' . $this->salary_to;
            }
        }

        return $salary;
    }

    //    Scopes
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
