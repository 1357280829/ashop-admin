<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'cover_url', 'sale_price', 'packing_price', 'is_on', 'sort', 'unit_name', 'admin_user_id',
    ];

    public function adminuser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product_relations');
    }
}
