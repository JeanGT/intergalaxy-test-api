<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'hourly_price',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function timesheets(){
        return $this->hasMany(Timesheet::class, 'user_id', 'id');
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function generatedReceipts(){
        return $this->hasMany(Receipt::class, 'employer_id', 'id');
    }

    public function myReceipts(){
        return $this->hasMany(Receipt::class, 'employee_id', 'id');
    }

    public function hasRole($role_name){
        return $this->role->name == $role_name;
    }
}
