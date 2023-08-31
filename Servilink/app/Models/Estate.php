<?php

namespace App\Models;

use App\Models\Security;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    public function security()
    {
        return $this->hasMany(Security::class);
    }
}