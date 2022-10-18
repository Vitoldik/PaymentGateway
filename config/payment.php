<?php

use Illuminate\Validation\Rule;

return [
    'first_merchant' => [
        'id' => env('FIRST_MERCHANT_ID'),
        'key' => env('FIRST_MERCHANT_KEY'),
        'limit' => env('FIRST_MERCHANT_LIMIT'),
        'validationRules' => [
            'merchant_id' => 'required|integer',
            'payment_id' => 'required|integer',
            'status' => [
                'required',
                'string',
                Rule::in(['new', 'pending', 'completed', 'expired', 'rejected'])
            ],
            'amount' => 'required|integer',
            'amount_paid' => 'required|integer',
            'timestamp' => 'required|integer',
            'sign' => 'required|string'
        ]
    ],
    'second_merchant' => [
        'id' => env('SECOND_MERCHANT_ID'),
        'key' => env('SECOND_MERCHANT_KEY'),
        'limit' => env('SECOND_MERCHANT_LIMIT'),
        'validationRules' => [
            'project' => 'required|integer',
            'invoice' => 'required|integer',
            'status' => [
                'required',
                'string',
                Rule::in(['new', 'pending', 'completed', 'expired', 'rejected'])
            ],
            'amount' => 'required|integer',
            'amount_paid' => 'required|integer',
            'rand' => 'required|string'
        ]
    ]
];
