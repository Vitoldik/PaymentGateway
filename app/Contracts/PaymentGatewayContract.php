<?php

namespace App\Contracts;

interface PaymentGatewayContract {

    public function createPayment(array $validated);

    public function updatePayment(array $validated);
}
