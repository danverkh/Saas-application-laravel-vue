<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuccessStoriesController extends Controller
{
    /**
     * @var int
     */
    private int $limit = 8;

    /**
     * Provision a new web server.
     *
     * @param string|null $industry
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(?string $industry = null): View
    {
        return view('success_stories', [
            'items'    => SuccessStory::latest()
                                      ->when($industry, fn(Builder $q) => $q->where('client_industry', $industry))
                                      ->limit($this->limit)
                                      ->get(),
            'industry' => $industry,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(Request $request): JsonResponse
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = SuccessStory::latest()
                             ->when($request->industry, fn(Builder $q) => $q->where('client_industry', $request->industry))
                             ->limit($this->limit);

        return response()->json([
            'items'      => $query->offset(($request->page - 1) * $this->limit)->get(),
            'reachedEnd' => !$query->offset($request->page * $this->limit)->exists(),
        ]);
    }
}
