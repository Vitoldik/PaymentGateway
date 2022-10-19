<?php

namespace App\Models;

use App\Contracts\PaymentGatewayContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondGatewayPayment extends Model implements PaymentGatewayContract
{
    use HasFactory;

    protected $table = 'second_gateway_payments';
    protected $primaryKey = 'invoice';
    public $incrementing = false;
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'project',
        'invoice',
        'status',
        'amount',
        'amount_paid',
        'rand',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    // Убираем запись UPDATED_AT в базу
    public function getUpdatedAtColumn() {
        return null;
    }

    public function createPayment(array $validated) {
        $this->query()->create($validated)->save();
    }

    public function updatePayment(array $validated) {
        $this->status = $validated['status'];
        $this->save();
    }
}
