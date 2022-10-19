<?php

namespace App\Utilities;

class PaymentUtils {

    public static function generateSign($params, $merchantName): string {
        ksort($params);

        if ($merchantName == 'first_merchant')
            unset($params['sign']);

        return hash(config("payment.${merchantName}.sign.hash"),
            join(config("payment.${merchantName}.sign.separator"), array_keys($params)) . config("payment.${merchantName}.key"));
    }

    public static function isLimitReached($model, $merchantName): bool {
        $amountOfThisDay = $model::query()->whereDate('created_at', date('Y-m-d'))->count();

        return $amountOfThisDay >= config("payment.${merchantName}.limit");
    }
}
