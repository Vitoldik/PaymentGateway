<?php

namespace App\Utilities;

class PaymentUtils {

    public static function generateSign($params, $separator, $key, $hash): string {
        ksort($params);
        unset($params['sign']);
        return hash($hash, join($separator, array_keys($params)) . $key);
    }
}
