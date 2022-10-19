<?php

use Illuminate\Validation\Rule;

return [
    'first_merchant' => [
        'id' => env('FIRST_MERCHANT_ID'),
        'key' => env('FIRST_MERCHANT_KEY'),
        'limit' => env('FIRST_MERCHANT_LIMIT'),
        'sign' => [
            'hash' => env('FIRST_MERCHANT_HASH'),
            'separator' => env('FIRST_MERCHANT_HASH_SEPARATOR')
        ],
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
        'sign' => [
            'hash' => env('SECOND_MERCHANT_HASH'),
            'separator' => env('SECOND_MERCHANT_HASH_SEPARATOR')
        ],
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
