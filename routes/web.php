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
});

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

    return \App\User::all();
});
