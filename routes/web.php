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
    return redirect('/computers');
});

Auth::routes();

Route::get('/login', function(){
    return redirect('https://auth.m4st3rx.com');
})->name('login');

Route::get('/home', 'ComputerController@index')->name('index');
Route::get('/computers', 'ComputerController@selector')->name('computers');

Route::prefix('computer')
    ->name('computer.')
    ->middleware('')
    ->group(function () {
    // GET
    Route::get('play/{id}', 'ComputerController@play')->name('play');
    Route::get('assembler/{id}', 'ComputerController@assembler')->name('assembler');
    Route::get('state/{id}', 'ComputerController@set_state')->name('state');
    Route::get('add-part/{id}/{item_id}', 'ComputerController@add_part')->name('add-part');
    Route::get('remove-part/{id}/{item_id}', 'ComputerController@remove_part')->name('remove-part');
}); //['middleware' => ['computer']]

Route::prefix('programs')
    ->name('programs.')
    ->group(function () {
    // GET
    Route::get('byteminer', 'ByteMinerController@byteminer')->name('byteminer');
    Route::get('byteminer/mine', 'ByteMinerController@byteminer_start')->name('byteminer.mine');
    Route::get('byteminer/collect', 'ByteMinerController@byteminer_collect')->name('byteminer.collect');
    Route::get('byteminer/sell', 'ByteMinerController@sell')->name('byteminer.sell');
});

Route::prefix('company')
    ->name('company.')
    ->group(function () {
    // GET
    Route::get('/', 'CompanyController@index')->name('index');
    Route::get('ranks', 'CompanyController@ranks')->name('ranks');
    Route::get('employees', 'CompanyController@employees')->name('employees');
    Route::get('management', 'CompanyController@management')->name('management');
    Route::get('ranks/up/{id}', 'CompanyController@ranksMoveUp')->name('ranks.up');
    Route::get('ranks/down/{id}', 'CompanyController@ranksMoveDown')->name('ranks.down');
    // POST
    Route::post('create', 'CompanyController@create')->name('create');
    Route::post('invite', 'CompanyController@invite')->name('invite');
    Route::post('ranks/create', 'CompanyController@createRank');
});

Route::get('/shop/buy/{id}', 'ShopController@purchase')->name('shop.buy');
Route::get('/shop', 'ShopController@index')->name('shop');


//Route::get('/shop/local', 'ShopController@findShop')->name('shop.local');
//Route::get('/shop/{name}', 'ShopController@findShop')->name('shop');
