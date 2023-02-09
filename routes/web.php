<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth0.authenticate'], function() {
    Route::get('/', [\App\Http\Controllers\MovementsController::class, 'all'])->name('home');

    Route::post('/', \App\Http\Controllers\MovementsController::class)->name('movements.store');
});

Route::get('/login', \Auth0\Laravel\Http\Controller\Stateful\Login::class)->name('login');
Route::get('/logout', \Auth0\Laravel\Http\Controller\Stateful\Logout::class)->name('logout');
Route::get('/callback', \Auth0\Laravel\Http\Controller\Stateful\Callback::class)->name('auth0.callback');
