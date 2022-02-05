<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('index');
});

Route::get('/todopage', 'TodoController@index')->middleware('auth');

Route::post('/store', 'TodoController@storeData' )->name('todo.store');

Route::delete('delete/{id}','TodoController@deleteData')->name('todo.delete');

Route::get('edit-task/{id}','TodoController@show');

Route::post('edit-task/{id}','TodoController@updateData')->name('todo.edit');

Route::post('check','TodoController@updateStatus')->name('todo.check');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
