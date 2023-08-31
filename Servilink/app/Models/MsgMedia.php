<?php

namespace App\Models;
use App\Models\Messaging;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsgMedia extends Model
{
    use HasFactory;

    public function message()
    {
        return $this->belongsTo(Messaging::class);
    }

}