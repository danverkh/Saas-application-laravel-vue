<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use App\Services\KeywordService;
use Illuminate\Http\JsonResponse;

class CampaignKeywordsController extends Controller
{
    /**
     * Cancel keyword
     */
    public function reactivate(Keyword $keyword, KeywordService $service): JsonResponse
    {
        $this->authorize('reactivate', $keyword);

        $success = $service->reactivate($keyword);

        return response()->json(['status' => $success ? 'success' : 'failed']);
    }

    /**
     * Cancel keyword
     */
    public function cancel(Keyword $keyword, KeywordService $service): JsonResponse
    {
        $this->authorize('cancel', $keyword);

        $success = $service->cancel($keyword);

        return response()->json(['status' => $success ? 'success' : 'failed']);
    }
}
