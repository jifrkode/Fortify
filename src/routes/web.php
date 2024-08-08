<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactController;

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
    return view('auth/login');
});

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

// Route::get('/contacts/export-excel', [ContactController::class, 'exportExcel'])->name('contacts.export');
Route::get('/contacts/export-CSV', [ContactController::class, 'exportCsv'])->name('contacts.export');

Route::get('/contacts/{id}', [ContactController::class, 'showDetail']);
