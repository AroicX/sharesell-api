<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
