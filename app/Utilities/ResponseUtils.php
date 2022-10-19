<?php

namespace App\Utilities;

use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;

class ResponseUtils {

    #[ArrayShape(['success' => "bool", 'message' => "null|string"])]
    public static function getJsonResponse(bool $isSuccess, ?string $message = null): JsonResponse {
        return response()->json([
            'success' => $isSuccess,
            'message' => $message
        ]);
    }

}
