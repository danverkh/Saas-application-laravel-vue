<?php

namespace App\Http\Controllers;

use App\Actions\Client\CreateClientAccount;
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
     * @throws \JsonException
     */
    public function order(OrderRequest $request): JsonResponse
    {
        //try {
            $user = DB::transaction(static function () use ($request) {
                $exists = User::where('email', $request->email)->exists();

                if ($exists) {
                    $user = User::firstWhere('email', $request->email);
                } else {
                    CreateClientAccount::handle(['email' => $request->email]);

                    $user = CreateUser::handle($request->email);
                }

                /** @var \App\Models\Order $order */
                $order = $user->clientAccount->client->orders()->create([
                    'name'                   => $request->domain . ' - '.count($request->selectedItems).' keywords',
                    'contact_email'          => $request->email,
                    'contact_language'       => $request->market,
                    'client_account_created' => $exists ? 'FALSE' : 'TRUE',
                    'employee_id'            => 0,
                    'creation_date'          => now()->toDateTimeString(),
                ]);

                foreach ($request->selectedItems as $item) {
                    $order->keywords()->create([
                        'keyword'               => $item['keyword'],
                        'domain'                => $request->domain,
                        'country'               => $request->market,
                        'search_volume'         => $item['search_volume'],
                        'monthly_fee'           => 0, // TODO: what fee to use here?
                        'setup_fee'             => 0, // TODO: what fee to use here?
                        'termination_confirmed' => 'FALSE',
                        'termination_executed'  => 'FALSE',
                        'setup_fee_invoiced'    => 'FALSE',
                        'creation_date'         => now()->toDateTimeString(),
                    ]);
                }

                return $user;
            });
        //} catch (\Throwable $e) {
        //    Log::error('Failed to create order', [
        //        'message' => $e->getMessage(),
        //        'request' => $request->validated(),
        //        'trace'   => $e->getTraceAsString(),
        //    ]);
        //
        //    DB::table('failed_orders_log')->insert([
        //        'request' => json_encode($request->validated(), JSON_THROW_ON_ERROR),
        //    ]);
        //
        //    return response()->json(['status' => 'error'], 500);
        //}

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
