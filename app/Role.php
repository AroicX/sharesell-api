<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    public function getUserByRole()
    {
        return $this->hasMany(User::class);
    }
}
