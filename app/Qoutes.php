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
}
