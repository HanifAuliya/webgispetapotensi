<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\CategoryController;



Route::get('/', [LandingPageController::class, 'index'])->name('landing');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    // dashboard 
    Route::get('/dashboard', [LocationController::class, 'index'])->name('dashboard');
    // table location
    Route::get('/location/create', [LocationController::class, 'create'])->name('location.create');
    Route::post('/location', [LocationController::class, 'store'])->name('location.store');
    Route::delete('/dashboard/{id}', [LocationController::class, 'destroy'])->name('dashboard.destroy');
    // edit
    Route::get('/location/{id}/edit', [LocationController::class, 'edit'])->name('location.edit');
    Route::patch('/location/{id}', [LocationController::class, 'update'])->name('location.update');
    // Routes untuk kategori
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
});


Route::get('/location', function () {
    return redirect()->route('location.create');
});
Route::get('/category', function () {
    return redirect()->route('category.create');
});

require __DIR__ . '/auth.php';
