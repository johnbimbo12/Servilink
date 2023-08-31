<?php

namespace App\Models;

use App\Models\estateuser;
use App\Models\Setting;

use App\Models\Messaging;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'role', // 1:admin, 2:manager, 3:user
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function estateuser()
    {
        return $this->hasOne(estateuser::class);
    }

    public function settings()
    {
        return $this->hasOne(Setting::class);
    }

    public function usermanager()
    {
        return $this->hasMany(estateuser::class);
    }

    public function messages()
    {
        return $this->hasMany(Messaging::class);
    }
}