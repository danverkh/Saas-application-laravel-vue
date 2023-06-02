<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Auth\LoginLinkController;
use App\Http\Controllers\BookADemoController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\SuccessStoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', HomepageController::class)->name('homepage');

Route::get('how-it-works', HowItWorksController::class)->name('how_it_works');
Route::get('success-stories/{industry?}', [SuccessStoriesController::class, 'index'])->name('success_stories');
Route::get('about-us', AboutUsController::class)->name('about_us');
Route::get('pricing', PricingController::class)->name('pricing');
Route::get('book-a-demo', [BookADemoController::class, 'form'])->name('book_a_demo');
Route::get('our-api', [StaticPageController::class, 'ourApi'])->name('our-api');

Route::post('checkout/order', [CheckoutController::class, 'order'])->name('checkout.order');
Route::get('thank-you', [CheckoutController::class, 'thankYou'])->name('checkout.thank_you');

Route::get('user/{hash}', LoginLinkController::class)->name('login.link');

Route::get('imprint', [StaticPageController::class, 'imprint'])->name('imprint');
Route::get('data-privacy', [StaticPageController::class, 'dataPrivacy'])->name('data_privacy');

require __DIR__.'/auth.php';

Route::get('{market}/{query}', [BookingController::class, 'index'])
    ->where('query', '.*')
    ->name('booking');
