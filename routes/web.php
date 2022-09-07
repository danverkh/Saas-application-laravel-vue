<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HowItWorksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', HomepageController::class)->name('homepage');

Route::get('{market}/{query}', [BookingController::class, 'index'])
    ->whereIn('market', ['at', 'ch', 'de', 'uk', 'fr', 'it', 'es'])
    ->name('booking');

Route::get('how-it-works', HowItWorksController::class)->name('how_it_works');


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

//require __DIR__.'/auth.php';
