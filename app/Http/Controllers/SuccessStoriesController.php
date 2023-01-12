<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;
use Illuminate\Contracts\View\View;
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
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('success_stories', [
            'items' => SuccessStory::latest()->limit($this->limit)->get(),
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
        $query = SuccessStory::latest()->limit($this->limit);

        return response()->json([
            'items'      => $query->offset(($request->page - 1) * $this->limit)->get(),
            'reachedEnd' => !$query->offset($request->page * $this->limit)->exists(),
        ]);
    }
}
