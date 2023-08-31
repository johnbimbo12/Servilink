<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Emergency;
use App\Models\User;


class EmergencyContacts extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function emergency()
    {
        return $this->belongsTo(Emergency::class);
    }
  
}