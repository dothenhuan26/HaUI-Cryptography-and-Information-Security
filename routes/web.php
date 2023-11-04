<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RSA\EncryptController;

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

Route::get('/', [EncryptController::class, 'index'])->name('index');
Route::post('/', [EncryptController::class, 'postMessage']);
Route::get('/download', [EncryptController::class, 'download'])->name('download');
