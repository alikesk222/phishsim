<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// ── Public tracking routes (no auth — accessed by phishing targets) ──────────
Route::prefix('t')->name('track.')->group(function () {
    Route::get('/pixel/{token}',  [TrackingController::class, 'pixel'])->name('pixel');
    Route::get('/click/{token}',  [TrackingController::class, 'click'])->name('click');
    Route::post('/submit/{token}', [TrackingController::class, 'submit'])->name('submit');
    Route::get('/report/{token}', [TrackingController::class, 'report'])->name('report');
});

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/',         [LoginController::class, 'showForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Authenticated app ─────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Employees
    Route::resource('employees', EmployeeController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::post('/employees/import', [EmployeeController::class, 'importCsv'])->name('employees.import');

    // Campaigns
    Route::resource('campaigns', CampaignController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::post('/campaigns/{campaign}/launch', [CampaignController::class, 'launch'])->name('campaigns.launch');
});
