<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailablePosition extends Model
{
    use HasFactory;

    protected $table = 'available_positions';

    protected $fillable = [
        'job_vacancy_id', 'position', 'capacity', 'apply_capacity'
    ];

    public $timestamps = false;

    public function vacancy(){
        return $this->belongsTo(JobVacancy::class);
    }

    public function positions(){
        return $this->hasOne(JobApplyPosition::class);
    }
}
