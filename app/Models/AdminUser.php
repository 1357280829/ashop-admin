<?php

namespace App\Models;

class AdminUser extends Model
{
    protected $hidden = ['password', 'remember_token'];

    public function stores()
    {
        return $this->hasMany(Store::class, 'admin_user_id', 'id');
    }
}
