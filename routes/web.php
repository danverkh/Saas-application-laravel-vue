<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginLinkController;
use App\Http\Controllers\BookADemoController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\SuccessStoriesController;
use App\Http\Controllers\SupportController;
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
    Route::get('campaigns', [CampaignsController::class, 'index'])->name('campaigns');
    Route::get('campaigns/{keyword}/keyword', [CampaignsController::class, 'keyword'])->name('campaigns.keyword');
    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::get('support', [SupportController::class, 'index'])->name('support');
});

Route::get('imprint', [StaticPageController::class, 'imprint'])->name('imprint');
Route::get('data-privacy', [StaticPageController::class, 'dataPrivacy'])->name('data_privacy');

Route::get('{market}/{query}', [BookingController::class, 'index'])->name('booking');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
