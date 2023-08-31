<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estateuser extends Model
{
    use HasFactory;
    protected $guard = [
        'user_id',
        'housenum',
        'phonenumber',
        'meternumber',
        'manager_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}