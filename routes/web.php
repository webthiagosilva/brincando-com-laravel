<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Register\PersonController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'person'], function () {
        Route::get('/', [PersonController::class, 'index'])->name('person.index');
        Route::post('/store', [PersonController::class, 'store'])->name('person.store');
        Route::get('/show/{person}', [PersonController::class, 'show'])->name('person.show');
        Route::put('/update/{person}', [PersonController::class, 'update'])->name('person.update');
        Route::delete('/delete/{person}', [PersonController::class, 'destroy'])->name('person.delete');
    });
});
