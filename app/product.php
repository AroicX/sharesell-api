<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function categores()
    {
        return $this->belongsTo(
            ProductCategory::class,
            'product_category',
            'category_id'
        );
    }
}
