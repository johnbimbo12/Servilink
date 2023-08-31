<?php

namespace App\Models;

use App\Models\Estate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use HasFactory;

    public function estate()
    {
        return $this->hasOne(Estate::class);
    }
}