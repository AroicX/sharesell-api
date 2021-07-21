<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
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
            Product::class,
            'products_category',
            'category_id'
        );
    }
}
