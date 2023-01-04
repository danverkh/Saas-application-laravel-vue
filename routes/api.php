<?php

use App\Http\Controllers\Api\AutoSuggestController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\KeywordsController;
use App\Http\Controllers\Api\PreviewRankController;
use App\Http\Controllers\Api\RankingsController;
use App\Http\Controllers\BookADemoController;
use App\Http\Controllers\SuccessStoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'throttle:api'], static function () {
    Route::get('rankings', [RankingsController::class, 'index'])->name('api.rankings');
    Route::get('preview/rank', [PreviewRankController::class, 'index'])->name('api.preview_rank');
    Route::get('autosuggest/domain', [AutoSuggestController::class, 'domain'])->name('api.autosuggest.domain');
    Route::get('domain/market/guess', [DomainController::class, 'marketGuess'])->name('api.domain.market.guess');
    Route::post('book-a-demo', [BookADemoController::class, 'store'])->name('api.book_a_demo.submit');
    Route::get('keyword/validate', [KeywordsController::class, 'validateKeyword'])->name('api.keyword.validate');
});

Route::post('keywords/relevance', [KeywordsController::class, 'relevance'])->name('api.keywords.relevance');
Route::get('success-stories/fetch', [SuccessStoriesController::class, 'fetch'])->name('api.success_stories.fetch');
