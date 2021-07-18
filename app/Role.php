<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'role_id',
        'name',
        'description',
    ];


    public function getUserByRole()
    {
        return $this->hasMany(User::class);
    }
}
