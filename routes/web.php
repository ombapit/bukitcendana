<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiKeuanganController;
use App\Http\Controllers\DataWargaController;

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
    return view('welcome');
});

Route::get('/transaksi-keuangan', [TransaksiKeuanganController::class, 'index'])->name('transaksi.index');
Route::get('/data-warga', [DataWargaController::class, 'index'])->name('warga.index');
