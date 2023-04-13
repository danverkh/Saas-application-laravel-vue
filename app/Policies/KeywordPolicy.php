<?php

namespace App\Policies;

use App\Models\Keyword;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KeywordPolicy
{
    /**
     * Determine whether the user can cancel keyword.
     */
    public function cancel(User $user, Keyword $keyword): bool
    {
        return $user->client->id === $keyword->order->client_id;
    }
}
