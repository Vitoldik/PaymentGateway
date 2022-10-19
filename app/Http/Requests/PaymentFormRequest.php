<?php

namespace App\Http\Requests;

use App\Utilities\ResponseUtils;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaymentFormRequest extends FormRequest {
    protected $stopOnFirstFailure = true;
    private ?string $merchantName = null;

    protected function prepareForValidation(): void {
        // Получаем content-type из заголовка
        $contentType = request()->header('content-type');

        // Ищем мерчант по content-type
        $this->merchantName = $contentType == 'application/json' ? 'first_merchant' : (str_contains($contentType, 'multipart/form-data') ? 'second_merchant' : null);

        // Если мерчант не найден или его нет в конфиге - выбрасываем исключение
        if (!$this->merchantName || !config()->has('payment.' . $this->merchantName))
            throw new HttpResponseException(ResponseUtils::getJsonResponse(false, 'Merchant not found!'));
    }

    public function rules() {
        return config('payment.' . $this->merchantName . '.validationRules'); // получаем правила для валидации из конфига
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(ResponseUtils::getJsonResponse(false, $validator->errors()->first()));
    }

    // Метод для получения имени мерчанта для использования в контроллере
    public function getMerchantName(): ?string {
        return $this->merchantName;
    }
}
