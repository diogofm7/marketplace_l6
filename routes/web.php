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

Route::group(['middleware' => ['auth']], function (){

    Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function (){

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::resource('categories', 'CategoryController');

    });

});

Auth::routes();
