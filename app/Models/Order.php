<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'phone',
        'email',
        'address',
        'division_id',
        'district_id',
        'upazila_id',
        'postal_code',
        'sub_total',
        'total_discount',
        'total_shipping_charge',
        'grand_total',
        'payment_type',
        'payment_status',
        'order_status',
        'zip',
        'country',
        'city'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}