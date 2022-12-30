<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AutoSuggestRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AutoSuggestController extends Controller
{
    /**
     * @param \App\Http\Requests\AutoSuggestRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function domain(AutoSuggestRequest $request): JsonResponse
    {
        $suggestions = DB::connection('production')
                         ->table('prospect_mail_domains')
                         ->selectRaw('mail_domain AS domain, title')
                         ->where('mail_domain', 'LIKE', "$request->domain%")
                         ->limit(1000)
                         ->get();

        return response()->json(compact('suggestions'));
    }
}
