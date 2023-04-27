<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DomainRequest;
use App\Services\Domain;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    /**
     * @param \App\Http\Requests\DomainRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function marketGuess(DomainRequest $request): JsonResponse
    {
        $item = DB::connection('production')
                  ->table('prospect_mail_domains')
                  ->select(['language_detected', 'registrant_country'])
                  ->where('mail_domain', 'LIKE', "$request->domain%")
                  ->first();

        if ($item?->registrant_country && Str::lower($item->registrant_country ?? '') !== 'xx') {
            $market = Str::lower($item->registrant_country);
        } else if ($item?->language_detected) {
            $market = Domain::getMarket($item->language_detected, $request->domain);
        } else {
            $market = null;
        }

        return response()->json(compact('market'));
    }
}
