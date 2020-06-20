@extends('layouts.app')

@section('content')

    <h1>Editar Poroduto</h1>
    <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nome Produto</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}">

            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ $product->description }}">

            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Conteudo</label>
            <textarea name="body" cols="30" rows="10" class="form-control @error('body') is-invalid @enderror">{{ $product->body }}</textarea>

            @error('body')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Preço</label>
            <input type="text" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}">

            @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Categorias</label>
            <select name="categories[]" class="form-control @error('categories') is-invalid @enderror" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @if($product->categories->contains($category)) selected @endif
                    >{{ $category->name }}</option>
                @endforeach
            </select>

            @error('categories')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Fotos do Produto</label>
            <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple>

            @error('photos.*')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-lg btn-success">Atualizar Produto</button>
        </div>
    </form>

    <hr>

    <div class="row">
        @foreach($product->photos as $photo)
            <div class="col-4 text-center">
                <img src="{{ asset('storage/' . $photo->image) }}" alt="" class="img-fluid">
                <form action="{{ route('admin.photo.remove') }}" method="post">
                    <input type="hidden" name="photoName" value="{{ $photo->image }}">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-danger">Remover</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.rawgit.com/plentz/jquery-maskmoney/master/dist/jquery.maskMoney.min.js"></script>
    <script>
        $('#price').maskMoney({prefix: '', allowNegative: false, thousands: '.', decimal: ','});
    </script>
@endsection
