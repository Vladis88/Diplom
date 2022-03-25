<?php

namespace App\Service\Payment;

/**
 * Class PaymentService
 */
class PaymentService
{
    /**
     * @var
     */
    private $client;

    /**
     * PaymentService constructor.
     */
    public function __construct()
    {
        \BeGateway\Settings::$shopId  = 361;
        \BeGateway\Settings::$shopKey= 'b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d';

        \BeGateway\Logger::getInstance()->setLogLevel(\BeGateway\Logger::INFO);
    }

    public function pay()
    {
        $transaction = new \BeGateway\PaymentOperation();

        $transaction->money->setAmount(1.00);
        $transaction->money->setCurrency('EUR');
        $transaction->setDescription('test order');
        $transaction->setTrackingId('my_custom_vsariable');

        $transaction->card->setCardNumber('4200000000000000');
        $transaction->card->setCardHolder('John Doe');
        $transaction->card->setCardExpMonth(1);
        $transaction->card->setCardExpYear(2030);
        $transaction->card->setCardCvc('123');

        $transaction->customer->setFirstName('John');
        $transaction->customer->setLastName('Doe');
        $transaction->customer->setCountry('LV');
        $transaction->customer->setAddress('Demo str 12');
        $transaction->customer->setCity('Riga');
        $transaction->customer->setZip('LV-1082');
        $transaction->customer->setIp('127.0.0.1');
        $transaction->customer->setEmail('john@example.com');

        $response = $transaction->submit();

        var_dump($response->getResponseArray());exit();
    }
}
