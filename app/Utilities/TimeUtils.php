<?php

namespace App\Utilities;

use Carbon\Carbon;

class TimeUtils {

    public static function timestampToDateTime($timestamp): Carbon {
        return Carbon::parse($timestamp)->setTimezone('Europe/Moscow');
    }

}
