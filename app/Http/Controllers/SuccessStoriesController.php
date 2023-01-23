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
    private int $limit = 16;

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
            'items'    => SuccessStory::query()
                                      ->when($industry, fn(Builder $q) => $q->where('client_industry', $industry))
                                      ->limit($this->limit)
                                      ->orderBy('id')
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
        $query = SuccessStory::query()
                             ->when($request->industry, fn(Builder $q) => $q->where('client_industry', $request->industry))
                             ->orderBy('id')
                             ->limit($this->limit);

        return response()->json([
            'items'      => $query->offset(($request->page - 1) * $this->limit)->get(),
            'reachedEnd' => !$query->offset($request->page * $this->limit)->exists(),
        ]);
    }
}
