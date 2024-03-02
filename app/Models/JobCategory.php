<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $table = 'job_categories';

    public $timestamps = false;


    protected $fillable = [
        'job_category'
    ];

    public function vacancy(){
        return $this->hasMany(JobVacancy::class);
    }

    public function validation(){
        return $this->hasMany(Validation::class);
    }
}
