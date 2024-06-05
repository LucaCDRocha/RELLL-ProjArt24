<?php

use App\Http\Controllers\HistoricsController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\InterestPointController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrailController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return redirect()->route('home');
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
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
    Route::post("/addTrail", [FavoriteController::class, 'addTrail'])->name('bookmark.addTrail');
    Route::get('/my-trails', [HistoricsController::class, 'showHistorics']);
});

require __DIR__ . '/auth.php';

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::resource("/trails", TrailController::class);

Route::resource("/interestPoints", InterestPointController::class);

Route::get('/search', [SearchController::class, 'search']);

Route::get('/map', [InterestPointController::class, 'map']);

Route::get('/settings', function () {
    return Inertia::render('Settings');
});

Route::get('trail-start/{id}', [TrailController::class, 'start'])->name('start');

// API

Route::get('/api/trails/{id}', [TrailController::class, 'showJson'])->name('trails.showJson');

Route::get('/api/interestPoints/{id}', [InterestPointController::class, 'showJson'])->name('interestPoints.showJson');

// Maintenance

Route::get('/maintenance', function () {
    return Inertia::render('Maintenance');
});