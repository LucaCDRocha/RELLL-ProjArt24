<?php

use App\Http\Controllers\InterestPointController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FavoriteController;
use App\Models\Trail;

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
});

require __DIR__ . '/auth.php';

Route::get('/home', [TrailController::class, 'home'])->name('home');
Route::resource("trails", TrailController::class);

Route::resource("interestPoints", InterestPointController::class);

Route::get('/search', function () {
    return Inertia::render('Search');
});

Route::get('/map', [InterestPointController::class, 'map']);

Route::get('/settings', function () {
    return Inertia::render('Settings');
});

Route::get('/favorites', function () {
    return Inertia::render('List');
});

//Route qui requiert authentification
Route::get('/my-trails', function () {
    return Inertia::render('History');
})->middleware(['auth', 'verified'])->name('history');

Route::get('trail-start/{id}', [TrailController::class, 'start'])->name('start');