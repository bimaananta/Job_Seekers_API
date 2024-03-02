<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;

    protected $table = 'validations';
    public $timestamps = false;


    protected $fillable = [
        'job_category_id', 'society_id', 'validator_id', 'status', 'work_experience', 'job_position', 'reason_accepted', 'validator_notes'
    ];

    public function category(){
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }
}
