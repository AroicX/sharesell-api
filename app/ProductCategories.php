<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category_name',
        'category_type',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(
            Products::class,
            'product_category',
            'category_id'
        );
    }
}
