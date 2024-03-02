<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Society extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'societies';


    protected $fillable = [
        'id_card_number', 'password', 'name', 'born_date', 'gender', 'address', 'regional_id', 'login_tokens'
    ];

    protected $hidden = [
        'login_tokens'
    ];

    public function regional(){
        return $this->belongsTo(Regional::class);
    }

    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
}
