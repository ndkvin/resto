<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;
use App\Http\Controllers\Admin\CashierConroller;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Manager\RevenueController;
use App\Http\Controllers\Manager\TableController as ManagerTableController;
use App\Http\Controllers\Manager\MenuController as ManagerMenuController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Auth::routes([
  'reset' => false,
  'verify' => false,
]);

Route::group([
  'prefix' => 'admin',
  'namespace' => 'App\Http\Controllers\Admin',
  'middleware' => ['auth', 'admin'],
  'as' => 'admin.',
], function() {
  Route::resource('category', CategoryController::class)->except(['create', 'edit']);
  Route::resource('menu', MenuController::class)->except(['create','edit']);
  Route::resource('table', TableController::class)->except(['create','edit']);
  Route::resource('cashier', CashierConroller::class)->except(['create','edit']);
  Route::resource('manager', ManagerController::class)->except(['create','edit']);
});

Route::group([
  'prefix' => 'manager',
  'namespace' => 'App\Http\Controllers\Manager',
  'middleware' => ['auth', 'manager'],
  'as' => 'manager.',
], function() {
  Route::resource('menu', ManagerMenuController::class)->except(['create', 'edit']);
  Route::resource('table', ManagerTableController::class)->except(['create', 'edit']);
  Route::resource('revenue', RevenueController::class)->except(['create', 'edit']);
});

Route::group([
  'prefix' => 'cashier',
  'namespace' => 'App\Http\Controllers\Cashier',
  'middleware' => ['auth', 'cashier'],
  'as' => 'cashier.',
], function() {
  Route::resource('table', TableController::class)->except(['create', 'edit']);
  Route::resource('reservation', ReservationController::class)->except(['create', 'edit']);
  Route::resource('order', OrderController::class);
});