<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'role_id',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /** check user is doctor
     * @return bool
     */
    public function isDoctor()
    {
        return Auth::user()->role->name === Role::DOCTOR;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function chatRooms()
    {
        return $this->belongsToMany(ChatRoom::class);
    }
}
