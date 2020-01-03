<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function index()
    {

        if(!auth()->check()){
            return redirect()->route('login');
        }

        $this->makePagSeguroSession();

        $cartItems = array_map(function ($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));

        $cartItems = array_sum($cartItems);

        return view('checkout', compact('cartItems'));
    }

    public function proccess(Request $request)
    {
        $dataPost = $request->all();
        $reference = 'XPTO';

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard(); //Inicializa o Metodo de Cartão de Crédito

        $creditCard->setReceiverEmail(env('PAGSEGURO_EMAIL')); //Email do recebedor, vindo do .ENV

        $creditCard->setReference($reference); //Referencia da venda

        $creditCard->setCurrency("BRL"); //Moeda

        $cartItems = session()->get('cart');

        foreach ($cartItems as $item) {
            $creditCard->addItems()->withParameters( //Adiciona Item a Venda
                $reference,
                $item['name'],
                $item['amount'],
                $item['price']
            );
        }


        // Dados Comprador
        $user = auth()->user();
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
        $creditCard->setSender()->setHash($dataPost['hash']);
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
        $creditCard->setToken($dataPost['card_token']);

        // Dados de parcelamento
        list($quantity, $installmentAmount) = explode('|', $dataPost['installment']);
        $installmentAmount = number_format($installmentAmount, 2, '.', '');
        $creditCard->setInstallment()->withParameters($quantity, $installmentAmount);

        // Dados Dono do cartão
        $creditCard->setHolder()->setBirthdate('01/10/1979');
        $creditCard->setHolder()->setName($dataPost['card_name']); // Equals in Credit Card
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

        var_dump($result);

    }

    private function makePagSeguroSession()
    {
        if(!session()->has('pagseguro_session_code')){
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            session()->put('pagseguro_session_code', $sessionCode->getResult());
        }
    }


}
