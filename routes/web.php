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
    return redirect('/login');
});

Auth::routes();

Route::get('/computers', 'ComputerController@index')->name('computers');
Route::get('/computer/assembler/{id}', 'ComputerController@assembler')->name('computer.assembler');
Route::get('/computer/add-part/{id}/{item_id}', 'ComputerController@add_part')->name('computer.add-part');
Route::get('/shop', 'ShopController@index')->name('shop');
Route::get('/shop/buy/{id}', 'ShopController@purchase')->name('shop.buy');
//Route::get('/shop/local', 'ShopController@findShop')->name('shop.local');
//Route::get('/shop/{name}', 'ShopController@findShop')->name('shop');
