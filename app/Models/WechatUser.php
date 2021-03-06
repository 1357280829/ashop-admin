<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class WechatUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nickname', 'phone', 'unionid', 'openid_mini_program', 'openid_official_account', 'avatar_url', 'gender',
        'country', 'province', 'city', 'admin_user_id',
    ];

    public function adminuser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id', 'id');
    }
}
