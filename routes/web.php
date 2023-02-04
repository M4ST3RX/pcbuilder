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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'ComputerController@selector')->name('computer_select');
Route::get('create', 'ComputerController@showCreateComputer')->name('computer_create');

Auth::routes();

Route::prefix('computer')
    ->name('computer.')
    ->middleware('computer')
    ->group(function () {
    // GET
    Route::get('/', 'ComputerController@play')->name('play');
    Route::get('inventory', 'ComputerController@inventory')->name('inventory');
    Route::get('assembler/{computer_id}', 'ComputerController@assembler')->name('assembler');
    Route::get('state/{computer_id}', 'ComputerController@set_state')->name('state');
    Route::get('add-part/{computer_id}/{item_id}', 'ComputerController@add_part')->name('add-part');
    Route::get('remove-part/{computer_id}/{item_id}', 'ComputerController@remove_part')->name('remove-part');

    // POST
    Route::post('create', 'ComputerController@createComputer')->name('create');
}); //['middleware' => ['computer']]

Route::prefix('programs')
    ->name('programs.')
    ->group(function () {
    // GET
    Route::get('miner/{name}', 'MinerController@miner')->name('miner');
    Route::get('miner/mine', 'ByteMinerController@byteminer_start')->name('byteminer.mine');
    Route::get('miner/collect', 'ByteMinerController@byteminer_collect')->name('byteminer.collect');
    Route::get('miner/sell', 'ByteMinerController@sell')->name('byteminer.sell');
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

Route::get('/shop', 'ShopController@index')->name('shop');

Route::prefix('api')
    ->middleware('auth')
    ->group(function(){
        Route::post('login', 'APIController@login_as');
        Route::post('items', 'APIController@items');
        Route::post('move-item', 'APIController@move_item');
        Route::post('miner/mine', 'APIController@toggle_miner');
        Route::post('miner/sell', 'APIController@miner_sell');

        Route::post('/shop/buy', 'ShopController@purchase')->name('shop.buy');

        Route::post('/reset-datetime', 'APIController@reset_date');
    });


//Route::get('/shop/local', 'ShopController@findShop')->name('shop.local');
//Route::get('/shop/{name}', 'ShopController@findShop')->name('shop');
