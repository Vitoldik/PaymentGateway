<?php

namespace App\Actions;

use App\Contracts\PaymentActionContract;
use App\Http\Requests\PaymentFormRequest;
use App\Models\FirstGatewayPayment;
use App\Utilities\PaymentUtils;
use App\Utilities\ResponseUtils;
use App\Utilities\TimeUtils;

class PaymentAction implements PaymentActionContract {

    // Добавил в ответах сообщения для лучшего понимания кода, по-хорошему они тут не нужны (зачем их отправлять на платежку 0_o?)
    public function __invoke(PaymentFormRequest $paymentRequest) {
        $merchantName = $paymentRequest->getMerchantName();

        if ($merchantName == 'first_merchant') {
            $validated = $paymentRequest->validated();
            ['status' => $status, 'payment_id' => $payment_id, 'sign' => $sign] = $validated;

            // Проверяем подпись
            if ($sign != PaymentUtils::generateSign($validated, ':', config("payment.${merchantName}.key"), 'sha256'))
                return ResponseUtils::getJsonResponse(false, 'Некорректная подпись!');

            $timestamp = TimeUtils::timestampToDateTime($validated['timestamp']);

            $payments = FirstGatewayPayment::query()->where('payment_id', $payment_id);

            // Обработка нового платежа
            if ($status == 'new') {
                if (!$payments->exists()) {
                    $validated['timestamp'] = $timestamp;
                    FirstGatewayPayment::query()->create($validated)->save();
                    return ResponseUtils::getJsonResponse(true, 'Платеж добавлен!');
                }

                return ResponseUtils::getJsonResponse(false, 'Платеж уже существует!');
            }

            if ($payments->exists()) {
                $payment = $payments->first();

                // Если платеж уже завершен, то ничего не делаем
                if ($payment->status == 'completed') {
                    return ResponseUtils::getJsonResponse(false, 'Этот платеж уже завершен!');
                }

                // Не знаю, нужно ли удаление при истечении срока действия платежа, но почему бы и нет :/
                if ($status == 'expired') {
                    $payment->delete();
                    return ResponseUtils::getJsonResponse(true, 'Платеж истек!');
                }

                // Если платеж не новый и не истек, то обновляем статус и время
                $payment->status = $status;
                $payment->timestamp = $timestamp;
                $payment->save();
                return ResponseUtils::getJsonResponse(true, 'Статус платежа обновлен!');
            }

            // Если у нас нет платежа в базе и приходит статус отличный от new - ничего не делаем
            return ResponseUtils::getJsonResponse(false, 'Платеж не был создан!');
        }
    }
}
