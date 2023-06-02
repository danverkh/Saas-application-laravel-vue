<?php

namespace App\Http\Controllers\Dashboard\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountPasswordChangeRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AccountPasswordChangeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function show(): View
    {
        return view('dashboard.account', [
            'page'  => 'change_password',
            'title' => 'Change Password',
        ]);
    }

    /**
     * @param \App\Http\Requests\AccountPasswordChangeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccountPasswordChangeRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json();
    }
}
