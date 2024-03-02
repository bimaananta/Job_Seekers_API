<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplyPosition extends Model
{
    use HasFactory;

    protected $table = 'job_apply_positions';

    public $timestamps = false;

    protected $fillable = [
        'date', 'society_id', 'job_vacancy_id', 'position_id', 'job_apply_societies_id', 'status'
    ];

    public function jobApplySociety(){
        return $this->belongsTo(JobApplySociety::class, 'job_apply_societies_id', 'id');
    }

    public function positions(){
        return $this->belongsTo(AvailablePosition::class, 'position_id', 'id');
    }
}

