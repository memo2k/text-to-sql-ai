<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'products_total_amount', 'shipping_amount', 'total_amount', 'status', 'payment_method', 'delivery_address', 'city', 'state', 'zip', 'country', 'customer_phone', 'customer_email', 'customer_first_name', 'customer_last_name', 'customer_notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
