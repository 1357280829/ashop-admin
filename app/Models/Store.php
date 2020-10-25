<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'key', 'admin_user_id', 'business_license_code', 'business_license_name', 'is_enable_bill_service',
        'mini_program_appid', 'mini_program_app_secret', 'payment_mch_id', 'payment_key',
    ];

    public function adminuser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id', 'id');
    }
}
