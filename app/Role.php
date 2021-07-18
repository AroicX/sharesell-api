<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function getUserByRole()
    {
        return $this->hasMany(User::class);
    }
}
