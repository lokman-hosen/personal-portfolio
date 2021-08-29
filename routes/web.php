<?php

use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::resource('category', CategoryController::class);


Route::name('admin.')->middleware(['web', 'auth'])->group(function () {
   /* Route::get('/users', function () {
        // Route assigned name "admin.users"...
    })->name('users');*/

    //Route::resource('photos', CategoryController::class);
});

Route::get('{any}', function () {
    return view('home');
})->where('any','.*');

