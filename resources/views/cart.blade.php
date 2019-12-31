@extends('layouts.front')

@section('content')

    <div class="row">
        <div class="col-12">
            <h2>Carrinho de Compras</h2>
            <hr>
        </div>
        <div class="col-12">
            @if($cart)
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $total = 0; @endphp
                    <form action="{{ route('cart.alter') }}" method="POST" id="alterCart">
                        @csrf
                        @foreach($cart as $key => $c)
                            <tr>
                                <td>{{ $c['name'] }}</td>
                                <td>R$ {{ number_format($c['price'], '2', ',', '.') }}</td>
                                <input type="hidden" name="product[{{ $key }}][name]" value="{{ $c['name'] }}">
                                <input type="hidden" name="product[{{ $key }}][price]" value="{{ $c['price'] }}">
                                <input type="hidden" name="product[{{ $key }}][slug]" value="{{ $c['slug'] }}">
                                <td><input type="number" min="1" name="product[{{ $key }}][amount]" value="{{ $c['amount'] }}" class="col-md-3"></td>
                                @php
                                    $subtotal = $c['price'] * $c['amount'];
                                    $total += $subtotal;
                                @endphp
                                <td>R$ {{ number_format($subtotal, '2', ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('cart.remove', ['slug' => $c['slug']]) }}" class="btn btn-sm btn-danger">Remover</a>
                                </td>
                            </tr>
                        @endforeach
                    </form>
                    <tr>
                        <td colspan="3">Total:</td>
                        <td colspan="2">R$ {{ number_format($total, '2', ',', '.') }}</td>
                    </tr>
                    </tbody>
                </table>

                <hr>

                <div class="col-md-12 text-center">
                    <a href="{{ route('checkout.index') }}" class="btn btn-lg btn-success float-right">Concluir Compra</a>
                    <a class="btn btn-lg btn-primary" href="#" onclick="document.getElementById('alterCart').submit();">Atualizar</a>
                    <a href="{{ route('cart.cancel') }}" class="btn btn-lg btn-danger float-left">Cancelar Compra</a>
                </div>
            @else
                <div class="alert alert-warning">Carrinho Vazio...</div>
            @endif
        </div>
    </div>

@endsection
