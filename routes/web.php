<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BurialRecordController;
use App\Http\Controllers\PublicPortalController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminApplicationsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [BurialRecordController::class, 'index'])->name('admin.index');
    Route::post('/records', [BurialRecordController::class, 'store'])->name('records.store');
    Route::delete('/records/{id}', [BurialRecordController::class, 'destroy'])->name('records.destroy');
    Route::get('/admin/applications', [AdminApplicationsController::class, 'index'])->name('admin.applications');
    Route::patch('/applications/{id}/status', [AdminApplicationsController::class, 'updateStatus'])->name('applications.updateStatus');
});

Route::get('/public', [PublicPortalController::class, 'index'])->name('public.index');
Route::get('/public/search', [PublicPortalController::class, 'search'])->name('public.search');
Route::get('/public/memorial/{id}', [PublicPortalController::class, 'memorial'])->name('public.memorial');
Route::get('/public/application', [ApplicationController::class, 'index'])->name('public.application');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');


Route::get('/admin', function () {
    return Inertia::render('Admin/Dashboard');
})->middleware('auth')->name('admin.dashboard');