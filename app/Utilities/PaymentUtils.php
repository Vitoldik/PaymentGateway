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
}
