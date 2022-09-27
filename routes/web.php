<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\UserController;
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

Route::get('/', function(){
    return redirect()->route('laundry.index');
});

Route::prefix('auth')->group(function(){
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware('auth')->group(function(){

    //route laundry input
    Route::prefix('laundry')->group(function(){
        Route::get('/', [LaundryController::class, 'index'])->name('laundry.index');
        Route::get('/create', [LaundryController::class, 'create'])->name('laundry.create');
        Route::post('/create', [LaundryController::class, 'post'])->name('laundry.post');
        Route::get('/{id}/edit', [LaundryController::class, 'edit'])->name('laundry.edit');
        Route::post('/{id}/update', [LaundryController::class, 'update'])->name('laundry.update');
        Route::get('/selesai', [LaundryController::class, 'selesai'])->name('laundry.show');
        Route::get('/{id}/select', [LaundryController::class, 'select'])->name('laundry.select');
        Route::get('/pending', [LaundryController::class, 'pending'])->name('laundry.pending');
        Route::post('/{id}/pending', [LaundryController::class, 'update_pending'])->name('laundry.pending.post');
        Route::post('/{id}/selesai', [LaundryController::class, 'update_selesai'])->name('laundry.selesai');
        Route::get('/laporan', [LaundryController::class, 'laporan'])->name('laundry.laporan');
        Route::delete('/{id}/hapus', [LaundryController::class, 'delete'])->name('laundry.hapus');
    });

    // route counter
    Route::prefix('counter')->group(function(){
        Route::get('/create', [CounterController::class, 'create'])->name('counter.create');
        Route::post('/create', [CounterController::class, 'post'])->name('counter.post');
    });

    //route users
    Route::prefix('user')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/', [UserController::class, 'post'])->name('user.post');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/{id}/update', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    });
});
