<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BusinessOpportunityController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/peluang_bisnis', [PublicController::class, 'opportunities'])->name('opportunities.index');
Route::get('/peluang_bisnis/{slug}', [PublicController::class, 'opportunityDetail'])->name('opportunities.show');

/*
|--------------------------------------------------------------------------
| ✅ Redirect default dashboard setelah login
|--------------------------------------------------------------------------
| Karena AuthenticatedSessionController masih redirect ke route('dashboard'),
| kita buat route dashboard yang mengarah ke admin opportunities index.
*/
Route::get('/dashboard', function () {
    return redirect()->route('admin.peluang_bisnis.index');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('/peluang_bisnis', BusinessOpportunityController::class);
    });

require __DIR__.'/auth.php';
