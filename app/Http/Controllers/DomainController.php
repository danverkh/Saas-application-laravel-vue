<?php

namespace App\Http\Controllers;

use App\Services\Domain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function marketGuess(Request $request): JsonResponse
    {
        $request->validate(['domain' => 'required']);

        $item = DB::connection('production')
                  ->table('prospect_mail_domains')
                  ->select(['language_detected', 'registrant_country'])
                  ->where('mail_domain', 'LIKE', "$request->domain%")
                  ->first();

        $languageOrCountryCode = $item->language_detected ?? $item->registrant_country ?? null;

        $market = Domain::getMarket($languageOrCountryCode, $request->domain);

        return response()->json(compact('market'));
    }
}
