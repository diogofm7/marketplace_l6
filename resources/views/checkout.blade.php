@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')

    <div class="container">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <h2>Dados Para pagamento</h2>
                    <hr>
                </div>
            </div>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Nome no Cartão</label>
                        <input type="text" name="card_name" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Numero do Cartão <span class="brand"></span></label>
                        <input type="text" name="card_number" class="form-control">
                        <input type="hidden" name="card_brand">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="">Mês de Expiração</label>
                        <input type="text" name="card_month" class="form-control">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="">Ano de Expiração</label>
                        <input type="text" name="card_year" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 form-group">
                        <label for="">Código de Segurança</label>
                        <input type="text" name="card_cvv" class="form-control">
                    </div>

                    <div class="col-md-12 installments form-group"></div>
                </div>

                <button class="btn btn-success btn-lg processCheckout">Efetuar Pagamento</button>

            </form>

            <div class="row mt-2">
                <h5 class="float-left my-auto" id="pagando"></h5>
                <img class="float-right" id="loader" style="display: none;" src={{ asset('assets/img/load.gif') }} alt='' width='30px' height='30px'>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        const sessionId = '{{ session()->get('pagseguro_session_code') }}';
        const urlThanks = '{{ route('checkout.thanks') }}';
        const urlProcess = '{{ route('checkout.proccess') }}';
        const amountTransaction = '{{ $cartItems }}';
        const csrf = '{{csrf_token()}}';
        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>

    <script src="{{ asset('js/pagseguro_functions.js') }}"></script>
    <script src="{{ asset('js/pagseguro_events.js') }}"></script>

@endsection
