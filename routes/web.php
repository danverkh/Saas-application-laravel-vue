<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Auth\LoginLinkController;
use App\Http\Controllers\BookADemoController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\SuccessStoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', HomepageController::class)->name('homepage');

Route::get('how-it-works', HowItWorksController::class)->name('how_it_works');
Route::get('success-stories', SuccessStoriesController::class)->name('success_stories');
Route::get('about-us', AboutUsController::class)->name('about_us');
Route::get('book-a-demo', [BookADemoController::class, 'form'])->name('book_a_demo');

Route::post('checkout/order', [CheckoutController::class, 'order'])->name('checkout.order');
Route::get('thank-you', [CheckoutController::class, 'thankYou'])->name('checkout.thank_you');

Route::get('user/{hash}', LoginLinkController::class)->name('login.link');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('reports', [DashboardController::class, 'reports'])->name('reports');
});

Route::get('{market}/{query}', [BookingController::class, 'index'])->name('booking');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
