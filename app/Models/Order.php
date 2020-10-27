<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no', 'taking_code', 'phone', 'arrived_time', 'carts', 'total_price', 'is_paid', 'remark', 'is_finished',
        'wechat_user_id', 'admin_user_id',
    ];

    protected $casts = [
        'carts' => 'json',
    ];

    public function wechatuser()
    {
        return $this->belongsTo(WechatUser::class);
    }

    public function adminuser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id', 'id');
    }

    public function getCartsDescAttribute()
    {
        $cartDesc = implode(',', array_column(array_column(json_decode($this->attributes['carts']), 'product'), 'name'));

        return $this->attributes['carts'] ? $cartDesc . ' 等商品' : '';
    }
}
