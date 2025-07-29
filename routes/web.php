<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BurialRecordController;
use App\Http\Controllers\PublicPortalController;
use App\Http\Controllers\ApplicationController;
use Inertia\Inertia;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [BurialRecordController::class, 'index'])->name('admin.index');
    Route::post('/records', [BurialRecordController::class, 'store'])->name('records.store');
    Route::delete('/records/{id}', [BurialRecordController::class, 'destroy'])->name('records.destroy');
});

Route::get('/public', [PublicPortalController::class, 'index'])->name('public.index');
Route::get('/public/search', [PublicPortalController::class, 'search'])->name('public.search');
Route::get('/public/memorial/{id}', [PublicPortalController::class, 'memorial'])->name('public.memorial');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');