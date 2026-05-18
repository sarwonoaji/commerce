<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'items',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payment_response',
        'created_by',
        'created_by_name',
    ];

    protected $casts = [
        'items' => 'array',
        'total' => 'decimal:2',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
