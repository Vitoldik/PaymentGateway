<?php

namespace App\Http\Controllers\API;

use App\Contracts\PaymentActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentFormRequest;

class PaymentController extends Controller {

    public function index(PaymentFormRequest $request, PaymentActionContract $action) {
        return $action($request);
    }
}
