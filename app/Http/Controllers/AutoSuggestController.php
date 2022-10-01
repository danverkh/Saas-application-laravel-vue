<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutoSuggestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function domain(Request $request): JsonResponse
    {
        $request->validate([
            'market' => 'required',
            'domain' => 'required',
        ]);

        $suggestions = DB::table('prospect_mail_domains')
                         ->selectRaw('mail_domain AS domain, title')
                         ->where('mail_domain', 'LIKE', "$request->domain%")
                         ->limit(4)
                         ->get();

        return response()->json(compact('suggestions'));
    }
}
