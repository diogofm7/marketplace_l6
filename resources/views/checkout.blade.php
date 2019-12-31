@extends('layouts.front')

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
                        <label for="">Numero do Cartão</label>
                        <input type="text" name="card_number" class="form-control">
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
                </div>

                <button class="btn btn-success btn-lg">Efetuar Pagamento</button>

            </form>
        </div>
    </div>

@endsection
