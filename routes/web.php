<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => ['computer']], function () {
    Route::get('/computer/play/{id}', 'ComputerController@play')->name('computer.play');
    Route::get('/computer/assembler/{id}', 'ComputerController@assembler')->name('computer.assembler');
    Route::get('/computer/state/{id}', 'ComputerController@set_state')->name('computer.state');
    Route::get('/computer/add-part/{id}/{item_id}', 'ComputerController@add_part')->name('computer.add-part');
    Route::get('/computer/remove-part/{id}/{item_id}', 'ComputerController@remove_part')->name('computer.remove-part');
});

Route::get('/programs/byteminer', 'ComputerController@byteminer')->name('programs.byteminer');
Route::get('/programs/byteminer/mine', 'ComputerController@byteminer_start')->name('programs.byteminer.mine');
Route::get('/programs/byteminer/collect', 'ComputerController@byteminer_collect')->name('programs.byteminer.collect');

Route::get('/shop/buy/{id}', 'ShopController@purchase')->name('shop.buy');
Route::get('/computers', 'ComputerController@selector')->name('computers');
Route::get('/home', 'ComputerController@index')->name('index');
Route::get('/shop', 'ShopController@index')->name('shop');


//Route::get('/shop/local', 'ShopController@findShop')->name('shop.local');
//Route::get('/shop/{name}', 'ShopController@findShop')->name('shop');
