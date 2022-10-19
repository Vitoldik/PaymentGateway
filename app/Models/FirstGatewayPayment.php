<?php

namespace App\Models;

use App\Contracts\PaymentGatewayContract;
use App\Utilities\TimeUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstGatewayPayment extends Model implements PaymentGatewayContract
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

    public function createPayment(array $validated) {
        $timestamp = TimeUtils::timestampToDateTime($validated['timestamp']);
        $validated['timestamp'] = $timestamp;
        $validated['created_at'] = now();

        $this->query()->create($validated)->save();
    }

    public function updatePayment(array $validated) {
        ['status' => $status, 'timestamp' => $timestamp] = $validated;

        $this->status = $status;
        $this->timestamp = TimeUtils::timestampToDateTime($timestamp);
        $this->save();
    }
}
