<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextController;

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

Route::get('/', [TextController::class, 'index']);
Route::post('/store', [TextController::class, 'store'])->name('text.store');
Route::get('/settime/edit/{id}', [TextController::class, 'edittext'])->name('text.editsettime');
Route::post('/text/edittime', [TextController::class, 'updatetime']);
Route::post('/text/play', [TextController::class, 'play']);


Route::get('/welcome', [App\Http\Controllers\Controller::class, 'index']);

Route::get('/test', function(){
    return view('test');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



