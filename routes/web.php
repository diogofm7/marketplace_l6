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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/product/{slug}', 'HomeController@single')->name('product.single');

Route::prefix('cart')->name('cart.')->group(function (){

    Route::get('/', 'CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');
    Route::get('remove/{slug}', 'CartController@remove')->name('remove');
    Route::post('alter', 'CartController@alter')->name('alter');
    Route::get('cancel', 'CartController@cancel')->name('cancel');

});


Route::group(['middleware' => ['auth']], function (){

    Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function (){

        Route::get('/', function (){
            return redirect()->route('admin.stores.index');
        })->name('index');

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::resource('categories', 'CategoryController');

        Route::post('photos/remove', 'ProductPhotoController@removePhoto')->name('photo.remove');

    });

});

Auth::routes();
