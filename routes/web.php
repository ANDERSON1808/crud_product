<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
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

Route::get('/', [ProductoController::class, 'index']);
Route::post('/modal_nuevo_producto', 'ProductoController@create')->name('modal_nuevo_producto');
Route::post('/nuevo_producto', 'ProductoController@store')->name('nuevo_producto');
Route::delete('/eliminar', 'ProductoController@destroy')->name('eliminar');
Route::resource('producto', 'ProductoController');
Route::post('/modal_editar_producto', 'ProductoController@edit')->name('modal_editar_producto');
Route::post('/update', 'ProductoController@update')->name('update');