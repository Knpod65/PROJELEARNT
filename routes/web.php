<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSubjectRecordController;
use App\Http\Controllers\DataSubjectRequestController;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/privacy-notice', 'privacy-notice')->name('privacy-notice');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('records', DataSubjectRecordController::class);

    Route::resource('data-subject-requests', DataSubjectRequestController::class)
        ->parameters(['data-subject-requests' => 'dataRequest']);

    Route::get('/audit-logs', [AuditLogController::class, 'index'])
        ->middleware('can:viewAny,'.AuditLog::class)
        ->name('audit-logs.index');
});

require __DIR__.'/auth.php';
