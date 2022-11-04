<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateUser;
use App\Http\Requests\OrderRequest;
use App\Models\Domain;
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
     * @throws \JsonException
     */
    public function order(OrderRequest $request): JsonResponse
    {
        try {
            $user = DB::transaction(static function () use ($request) {
                $user = User::firstWhere('email', $request->email) ?? CreateUser::handle($request->email);

                $domain = Domain::firstOrCreate(['name' => $request->validated('domain')]);

                /** @var \App\Models\Order $order */
                $order = $user->orders()->create([
                    ...$request->validated(),
                    'domain_id' => $domain->id,
                ]);

                foreach ($request->selectedItems as $keyword) {
                    $order->keywords()->create([
                        ...$keyword,
                        'domain_id' => $domain->id,
                    ]);
                }

                return $user;
            });
        } catch (\Throwable $e) {
            Log::error('Failed to create order', [
                'message' => $e->getMessage(),
                'request' => $request->validated(),
                'trace'   => $e->getTraceAsString(),
            ]);

            DB::table('failed_orders_log')->insert([
                'request' => json_encode($request->validated(), JSON_THROW_ON_ERROR),
            ]);

            return response()->json(['status' => 'error'], 500);
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
