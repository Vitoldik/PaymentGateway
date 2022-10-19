<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstGatewayPayment extends Model
{
    use HasFactory;

    protected $table = 'first_gateway_payments';
    protected $primaryKey = 'payment_id';
    public $incrementing = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'merchant_id',
        'payment_id',
        'status',
        'amount',
        'amount_paid',
        'timestamp',
        'sign',
        'created_at'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'created_at' => 'datetime'
    ];

    // Убираем запись UPDATED_AT в базу
    public function getUpdatedAtColumn() {
        return null;
    }
}
