## О реализации тестового задания

Оба платёжных шлюза обращаются на один callback url (http://localhost:8080/api/payment), далее происходит валидация входных данных (в классе PaymentFormRequest).
Перед валидацией (метод prepareForValidation) по заголовку из content-type определяется название мерчанта. Если входные данные корректны, то в PaymentAction выполняется создание или изменения платежа.

## Конфигурация (config/payment.php)
<img src="https://i.imgur.com/MEMQ96e.png" alt="Файл конфигурации">
