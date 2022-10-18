<?php

namespace App\Providers;

use App\Actions\PaymentAction;
use App\Contracts\PaymentActionContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider {

    public array $bindings = [
        PaymentActionContract::class => PaymentAction::class,
    ];

}
