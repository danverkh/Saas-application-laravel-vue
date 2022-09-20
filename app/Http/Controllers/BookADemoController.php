<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookADemoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BookADemoController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function form(): View
    {
        return view('book_a_demo');
    }

    /**
     * @param \App\Http\Requests\BookADemoRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookADemoRequest $request): JsonResponse
    {

        return response()->json(['status' => 'success']);
    }
}
