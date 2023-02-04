<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function computers()
    {
        return $this->hasMany(Computer::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'user_id');
    }

    public function company_rank()
    {
        return $this->hasOne(CompanyRanks::class, 'id', 'company_rank_id');
    }

    public function getBalance() {
        return '$' . number_format($this->money / 100, 2, '.', ' ');
    }
}
