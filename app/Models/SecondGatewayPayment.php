<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondGatewayPayment extends Model
{
    use HasFactory;

    protected $table = 'second_gateway_payments';
    protected $primaryKey = 'invoice';
    public $incrementing = false;
    public $timestamps = false;

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
}
