<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SupportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function show(): View
    {
        return view('dashboard.support');
    }

    /**
     * @param string $category
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function faq(string $category): View|RedirectResponse
    {
        $faqs = Faq::query()
                   ->where('category', $category)
                   ->orderBy('order')
                   ->get();

        if ($faqs->isEmpty()) {
            return redirect()->route('dashboard.support');
        }

        return view('dashboard.support', compact('faqs'));
    }
}
