<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,hasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function hours()
    {
        return round($this->shifts->sum('duration') / 60);
    }
    public function active_shift()
    {
        return $this->hasOne(Shift::class)->where('end_time', null);
    }
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }
    public function paid_this_month()
    {
        return $this->salaries()->whereMonth('created_at', now()->month)->sum('amount');
    }
    public function remaining_this_month()
    {
        return $this->monthly_salary - $this->paid_this_month();
    }
}
