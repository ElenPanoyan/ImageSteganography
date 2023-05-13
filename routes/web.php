<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaveController;


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
Route::post('/data-encode', [SaveController::class, 'createEncode'])->name('save-encode');
Route::post('/data-decode', [SaveController::class, 'createDecode'])->name('save-decode');


Route::post('/test', [SaveController::class,'test']);
Route::get('/testik', [SaveController::class, 'test1']);
