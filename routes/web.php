<?php

use App\Http\Controllers\HistoricsController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\InterestPointController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource("/bookmark", FavoriteController::class);
    Route::get('/my-trails', [HistoricsController::class, 'showHistorics']);
});

require __DIR__ . '/auth.php';

Route::get('/home', function () {
    return Inertia::render('Home');
});
Route::resource("trails", TrailController::class);

Route::resource("interestPoints", InterestPointController::class);

Route::get('/search', function () {
    return Inertia::render('Search');
});

Route::get('/map', function () {
    return Inertia::render('Map');
});

Route::get('/settings', function () {
    return Inertia::render('Settings');
});

// Route::get('/favorites', function () {
//     return Inertia::render('List');
// });
