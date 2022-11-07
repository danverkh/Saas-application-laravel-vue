<?php

namespace App\Http\Controllers\Dashboard\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountBillingAddressRequest;
use App\Models\Country;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class AccountBillingAddressController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function show(): View
    {
        return view('dashboard.account', [
            'page'           => 'billing_address',
            'title'          => 'Billing Address',
            'billingAddress' => auth()->user()->billingAddress,
            'countryOptions' => Country::dropdownOptions(),
        ]);
    }

    /**
     * @param \App\Http\Requests\AccountBillingAddressRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccountBillingAddressRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $user->billingAddress()
             ->updateOrCreate(['user_id' => auth()->id()], $request->validated());

        return response()->json();
    }
}
