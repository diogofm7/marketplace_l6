<?php

namespace App\Payment\PagSeguro;

class CreditCard
{
    private $items;
    private $user;
    private $cardInfo;
    private $reference;

    public function __construct($items, $user, $cardInfo, $reference)
    {
        $this->items = $items;
        $this->user = $user;
        $this->cardInfo = $cardInfo;
        $this->reference = $reference;
    }

    public function doPayment()
    {

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard(); //Inicializa o Metodo de Cartão de Crédito

        $creditCard->setReceiverEmail(env('PAGSEGURO_EMAIL')); //Email do recebedor, vindo do .ENV

        $creditCard->setReference($this->reference); //Referencia da venda

        $creditCard->setCurrency("BRL"); //Moeda

        $cartItems = $this->items;

        foreach ($cartItems as $item) {
            $creditCard->addItems()->withParameters( //Adiciona Item a Venda
                $this->reference,
                $item['name'],
                $item['amount'],
                $item['price']
            );
        }


        // Dados Comprador
        $user = $this->user;
        $email = env('PAGSEGURO_ENV') == 'sandbox' ? 'test@sandbox.pagseguro.com.br' : $user->email;

        $creditCard->setSender()->setName($user->name);
        $creditCard->setSender()->setEmail($email);
        $creditCard->setSender()->setPhone()->withParameters(
            11,
            56273440
        );
        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            '48404014701'
        );
        $creditCard->setSender()->setHash($this->cardInfo['hash']);
        $creditCard->setSender()->setIp('127.0.0.0');

        // Dados de Entrega
        $creditCard->setShipping()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        //Dados do Cartão de Crédito
        $creditCard->setBilling()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        // Token cartão
        $creditCard->setToken($this->cardInfo['card_token']);

        // Dados de parcelamento
        list($quantity, $installmentAmount) = explode('|', $this->cardInfo['installment']);
        $installmentAmount = number_format($installmentAmount, 2, '.', '');
        $creditCard->setInstallment()->withParameters($quantity, $installmentAmount);

        // Dados Dono do cartão
        $creditCard->setHolder()->setBirthdate('01/10/1979');
        $creditCard->setHolder()->setName($this->cardInfo['card_name']); // Equals in Credit Card
        $creditCard->setHolder()->setPhone()->withParameters(
            11,
            56273440
        );
        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            '48404014701'
        );

        // Metodo de Pagamento
        $creditCard->setMode('DEFAULT');

        //Executa o Pagamento
        $result = $creditCard->register(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        return $result;
    }

}
