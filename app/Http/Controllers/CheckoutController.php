<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateUser;
use App\Http\Requests\OrderRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    /**
     * @param \App\Http\Requests\OrderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function order(OrderRequest $request): JsonResponse
    {
        $user = User::firstWhere('email', $request->email) ?? CreateUser::handle($request->email);

        /** @var \App\Models\Order $order */
        $order = $user->orders()->create($request->validated());

        foreach ($request->selectedItems as $keyword) {
            $order->keywords()->create($keyword);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * @param \App\Http\Requests\OrderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateRequest(OrderRequest $request): JsonResponse
    {
        return response()->json(['status' => 'valid']);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function thankYou(): View
    {
        return view('checkout.thank_you');
    }
}
