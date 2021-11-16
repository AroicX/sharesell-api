<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qoutes extends Model
{
    use HasFactory;

    protected $fillables = [
        'qoutes_id',
        'reseller_id',
        'supplier_id',
        'product_id',
        'origin_state',
        'origin_city',
        'destination_state',
        'destination_city',
        'delivery_fee',
        'payload',
    ];

    public function Reseller()
    {
        return $this->belongsTo(Reseller::class, 'reseller_id', 'user_id');
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'user_id');
    }

    public function Product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
