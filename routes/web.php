<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomepageController;
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


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

//require __DIR__.'/auth.php';
