<?php

namespace App\Actions;

use App\Contracts\PaymentActionContract;
use App\Http\Requests\PaymentFormRequest;
use App\Utilities\PaymentUtils;
use App\Utilities\ResponseUtils;

class PaymentAction implements PaymentActionContract {

    // Добавил в ответах сообщения для лучшего понимания кода, по-хорошему они тут не нужны (зачем их отправлять на платежку 0_o?)
    public function __invoke(PaymentFormRequest $paymentRequest) {
        $merchantName = $paymentRequest->getMerchantName();
        $validated = $paymentRequest->validated();

        $sign = $merchantName == 'first_merchant' ? $validated['sign'] : $paymentRequest->header('Authorization');

        // Проверяем подпись
        if (!$sign || $sign != PaymentUtils::generateSign($validated, $merchantName))
            return ResponseUtils::getJsonResponse(false, 'Некорректная подпись!');

        $status = $validated['status'];

        // Получаем необходимую модель в зависимости от мерчанта
        $modelName = $merchantName == 'first_merchant' ? 'FirstGatewayPayment' : 'SecondGatewayPayment';
        $model = app("App\Models\\$modelName");

        // Ищем платеж по первичному ключу
        $payment = $model::query()->find($validated[$model->getKeyName()]);

        // Обработка нового платежа
        if ($status == 'new') {
            if (!$payment) {
                $model->createPayment($validated);
                return ResponseUtils::getJsonResponse(true, 'Платеж добавлен!');
            }

            return ResponseUtils::getJsonResponse(false, 'Платеж уже существует!');
        }

        if ($payment) {
            // Если платеж уже завершен, то ничего не делаем
            if ($payment->status == 'completed') {
                return ResponseUtils::getJsonResponse(false, 'Этот платеж уже завершен!');
            }

            // Не знаю, нужно ли удаление при истечении срока действия платежа, но почему бы и нет :/
            if ($status == 'expired') {
                $payment->delete();
                return ResponseUtils::getJsonResponse(true, 'Платеж истек!');
            }

            // Если платеж не новый и не истек, то обновляем статус и в случае первого мерчанта и время
            $payment->updatePayment($validated);

            return ResponseUtils::getJsonResponse(true, 'Статус платежа обновлен!');
        }

        // Если у нас нет платежа в базе и приходит статус отличный от new - ничего не делаем
        return ResponseUtils::getJsonResponse(false, 'Платеж не был создан!');
    }
}
