<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RankingsController;
use App\Http\Controllers\PreviewRankController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('rankings', [RankingsController::class, 'index'])->name('api.rankings');
Route::get('preview/rank', [PreviewRankController::class, 'index'])->name('api.preview_rank');
Route::post('checkout/order', [CheckoutController::class, 'order'])->name('api.checkout.order');
