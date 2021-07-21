<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_category',
        // 'product_name',
        'product_images',
        'product_description',
        'product_price',
        'product_weight',
        'product_size',
        'product_quantity',
        'product_number',
        'product_retail_price',
        'pickup_addreess',
        'state',
        'city',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
    public function category()
    {
        return $this->hasOne(
            ProductCategory::class,
            'category_id',
            'product_category'
        );
    }
}
