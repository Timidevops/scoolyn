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

Route::get('/', function () {
    return view('welcome');
});

Route::post('academic-session', [\App\Http\Controllers\Tenant\AcademicSession\AcademicSessionsController::class, 'store'])->name('storeAcademicSession');

//Route::middleware('tenant')->group(function() {
//    Route::get('/', function () {
//    return view('welcome');
//});
//});

//Route::domain('');
