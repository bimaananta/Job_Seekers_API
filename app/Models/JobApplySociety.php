<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplySociety extends Model
{
    use HasFactory;

    protected $table = 'job_apply_societies';

    public $timestamps = false;


    protected $fillable = [
        'notes', 'date', 'society_id', 'job_vacancy_id'
    ];

    public function vacancy(){
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'id');
    }

    public function position(){
        return $this->hasMany(JobApplyPosition::class, 'job_apply_societies_id', 'id');
    }
}
