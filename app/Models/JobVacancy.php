<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $table = 'job_vacancies';

    protected $fillable = [
        'job_category_id', 'company', 'address', 'description'
    ];

    public $timestamps = false;

    public function category(){
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }

    public function available_position(){
        return $this->hasMany(AvailablePosition::class);
    }

    public function job_apply_society(){
        return $this->hasMany(JobApplySociety::class, 'job_apply_societies_id', 'id');
    }
}
