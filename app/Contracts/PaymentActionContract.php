<?php

namespace App\Contracts;

use App\Http\Requests\PaymentFormRequest;

interface PaymentActionContract {

    public function __invoke(PaymentFormRequest $paymentRequest);

}
