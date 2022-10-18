<?php

namespace App\Actions;

use App\Contracts\PaymentActionContract;
use App\Http\Requests\PaymentFormRequest;

class PaymentAction implements PaymentActionContract {

    public function __invoke(PaymentFormRequest $paymentRequest) {
        return $paymentRequest->getMerchantName();
    }
}
