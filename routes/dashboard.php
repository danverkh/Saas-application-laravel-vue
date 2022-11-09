<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Dashboard\Account\AccountBillingAddressController;
use App\Http\Controllers\Dashboard\Account\DetailsController;
use App\Http\Controllers\Dashboard\CampaignsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SupportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::group(['as' => 'dashboard.', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('campaigns', [CampaignsController::class, 'index'])->name('campaigns');
    Route::get('campaigns/{keyword}/keyword', [CampaignsController::class, 'keyword'])->name('campaigns.keyword');

    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::get('account/details', [DetailsController::class, 'show'])->name('account.details');
    Route::get('account/billing-address', [AccountBillingAddressController::class, 'show'])->name('account.billing_address');
    Route::put('account/billing-address', [AccountBillingAddressController::class, 'update'])->name('account.billing_address.save');

    Route::get('support', [SupportController::class, 'show'])->name('support');
});
