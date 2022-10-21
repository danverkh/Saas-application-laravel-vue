<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateUser;
use App\Http\Requests\OrderRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * @param \App\Http\Requests\OrderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function order(OrderRequest $request): JsonResponse
    {
        try {
            $user = DB::transaction(static function () use ($request) {
                $user = User::firstWhere('email', $request->email) ?? CreateUser::handle($request->email);

                /** @var \App\Models\Order $order */
                $order = $user->orders()->create($request->validated());

                foreach ($request->selectedItems as $keyword) {
                    $order->keywords()->create($keyword);
                }

                return $user;
            });
        } catch (\Throwable $e) {
            Log::error('Failed to create order', [
                'message' => $e->getMessage(),
                'request' => $request->validated(),
                'trace'   => $e->getTraceAsString(),
            ]);

            DB::table('failed_orders_log')->insert(['request' => $request->validated()]);

            return response()->json(['status' => 'error']);
        }

        Auth::guard('web')->login($user);

        return response()->json(['status' => 'success']);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function thankYou(): View
    {
        return view('checkout.thank_you');
    }
}
