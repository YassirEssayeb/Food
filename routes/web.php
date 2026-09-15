<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/menu', [PublicController::class, 'menu'])->name('menu');
Route::get('/reservation', [PublicController::class, 'reservation'])->name('reservation');
Route::post('/reservation', [PublicController::class, 'storeReservation'])->name('reservation.store');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'storeMessage'])->name('contact.store');

Route::post('/order', [PublicController::class, 'storeOrder'])->name('order.store');
Route::match(['get', 'post'], '/review', [PublicController::class, 'storeReview'])->name('review.store');

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');
});

// Admin Protected Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    
    Route::resource('menu-items', AdminController::class)->names([
        'index' => 'menu-items.index',
        'create' => 'menu-items.create',
        'store' => 'menu-items.store',
        'edit' => 'menu-items.edit',
        'update' => 'menu-items.update',
        'destroy' => 'menu-items.destroy',
    ])->parameters(['menu-items' => 'menuItem']);
    
    // Explicitly define index for menu-items to point to index_menu
    Route::get('/menu-items', [AdminController::class, 'index_menu'])->name('menu-items.index');
    
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
    Route::post('/reservations/{reservation}/status', [AdminController::class, 'updateReservationStatus'])->name('admin.reservations.status');
    Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::post('/messages/{message}/read', [AdminController::class, 'markMessageRead'])->name('admin.messages.read');
});
