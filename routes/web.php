<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;
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
    return view('pages.admin.index');
});

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
  Route::resource('category', CategoryController::class)->except(['edit']);
});
