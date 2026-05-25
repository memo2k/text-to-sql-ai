<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'products_total_amount',
        'shipping_amount',
        'total_amount',
        'status',
        'payment_method',
        'delivery_address',
        'city',
        'state',
        'zip',
        'country',
        'customer_notes',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
