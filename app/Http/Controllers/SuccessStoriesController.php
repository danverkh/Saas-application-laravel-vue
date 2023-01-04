<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class SuccessStoriesController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('success_stories');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(): JsonResponse
    {
        $items = SuccessStory::all();

        return response()->json($items);
    }
}
