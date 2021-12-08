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

//Login
Route::get('login', 'AuthController@login')->name('login')->middleware('guest');
Route::post('login', 'AuthController@attempt')->name('attempt');

Route::group([
    'middleware'    => 'auth'
], function () {

    Route::get('/', 'DashboardController@index')->name('admin');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('logout', 'AuthController@logout')->name('logout');

    Route::get('order/{order}/print', 'OrderController@print')->name('order.print');

    Route::resources([
        'order' => 'OrderController',
        'user' => 'UserController',
        'role' => 'RoleController'
    ]);
});

