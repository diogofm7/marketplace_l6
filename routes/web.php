<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $helloWorld = 'Hello World';
    return view('welcome', compact('helloWorld'));
})->name('home');

Route::get('/model', function (){
    //$products = \App\Product::all();

//    $user = new \App\User();
//    $user = \App\User::find(1);
//    $user->name = 'Usuário Editado';
//    $user->email = 'email@teste.com';
//    $user->password = bcrypt('12345678');
//    $user->save();
//    \App\User::all(); - Retorna todos os Usuarios
//    \App\User::find(3); - Retorna Usuario especifico pelo id
//    \App\User::Where('name', 'Orin Considine')->first(); - Query com WHERE
//    \App\User::paginate(10); - Dados Paginados

//    $user = \App\User::create([
//        'name' => 'Diogo Ferreira',
//        'email' => 'diogo@teste.com.br',
//        'password' => bcrypt('0123456789')
//    ]);

//    $user = \App\User::find(42);
//    $user->update([
//       'name' => 'Atualizando com Mass Update'
//    ]); //Retorna true or false

    //Como Eu faria para pegar a loja de um usuario
//    $user = \App\User::find(4);
//    dd($user->store()->count());

   //Pegar produtos da loja
//    $store = \App\Store::find(1);
//    return $store->products; | $store->products()->where('id', 4)->get();

    //Pegar categorias de uma loja
//    $category = \App\Category::find(1);
//    $category->products;

    //Criar uma loja para um usuario
//    $user = \App\User::find(10);
//    $store = $user->store()->create([
//        'name' => 'Loja Teste',
//        'description' => 'Loja Teste de Produtos de Insformática',
//        'phone' => 'XX-XXXXX-XXXX',
//        'mobile_phone' => 'XX-XXXXX-XXXX',
//        'slug' => 'loja-teste'
//    ]);

    //Criar um produto para uma loja
//    $store = \App\Store::find(41);
//    $product = $store->products()->create([
//        'name' => 'Notebook Dell',
//        'description' => 'Core I5 12GB',
//        'body' => 'Qualquer Coisa...',
//        'price' => 2999.90,
//        'slug' => 'notebook-dell'
//    ]);

    //Criar uma categoria
//    \App\Category::create([
//       'name' => 'Games',
//       'description' => null,
//       'slug' => 'games'
//    ]);
//
//    \App\Category::create([
//        'name' => 'Notebooks',
//        'description' => null,
//        'slug' => 'notebooks'
//    ]);
//
//    return \App\Category::all();

    //Adicionar um produto para uma categoria ou vice-versa
//    $product = \App\Product::find(44);
//    dd($product->categories()->sync([2]));


    return \App\User::all();
});


Route::group(['middleware' => ['auth']], function (){

    Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function (){

//    Route::prefix('stores')->name('stores.')->group(function (){
//
//        Route::get('/', 'StoreController@index')->name('index');
//        Route::get('/create', 'StoreController@create')->name('create');
//        Route::post('/store', 'StoreController@store')->name('store');
//        Route::get('/{store}/edit', 'StoreController@edit')->name('edit');
//        Route::post('/update/{store}', 'StoreController@update')->name('update');
//        Route::get('/destroy/{store}', 'StoreController@destroy')->name('destroy');
//
//    });

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');

    });

});




Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
