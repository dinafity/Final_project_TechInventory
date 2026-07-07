<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [ItemController::class, 'index'])->name('admin.dashboard');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
    
    Route::get('/admin/public-api', [ItemController::class, 'getPublicApi'])->name('admin.api');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/items', [ItemController::class, 'indexUser'])->name('items.user');

    Route::post('/items/{id}/transaction', [ItemController::class, 'transaction'])->name('items.transaction');
});