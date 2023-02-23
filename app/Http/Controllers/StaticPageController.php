<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class StaticPageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function imprint(): View
    {
        return view('imprint');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function dataPrivacy(): View
    {
        return view('data_privacy');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function ourApi(): View
    {
        $endpoints = [
            [
                'type'        => 'GET',
                'url'         => 'get_keywords_for_domain',
                'description' => 'Returns all bookable keywords for a domain, with search volume, cpc; price, data directly from Google.',
            ],
            [
                'type'        => 'GET',
                'url'         => 'get_booked_keywords_of_domain',
                'description' => 'Returns all currently booked keywords for a domain, also with the above data.',
            ],
            [
                'type'        => 'GET',
                'url'         => 'get_booked_keywords_of_account',
                'description' => 'Returns all currently booked keywords of an account grouped by domain, also with the above data.',
            ],
            [
                'type'        => 'GET',
                'url'         => 'predict_keyword',
                'description' => 'Returns an array of arrays timestamps from now with our prediction for rank, traffic value, cost for that keyword.',
            ],
            [
                'type'        => 'POST',
                'url'         => 'book_keyword',
                'description' => 'Orders a keyword.',
            ],
            [
                'type'        => 'POST',
                'url'         => 'cancel_keyword',
                'description' => 'Cancels a keyword at the next possible date.',
            ],
        ];

        return view('our_api', compact('endpoints'));
    }
}
