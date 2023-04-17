<?php

namespace App\Policies;

use App\Models\Keyword;
use App\Models\User;

class KeywordPolicy
{
    /**
     * Determine whether the user can cancel keyword.
     */
    public function reactivate(User $user, Keyword $keyword): bool
    {
        return $user->client->id === $keyword->order->client_id;
    }

    /**
     * Determine whether the user can cancel keyword.
     */
    public function cancel(User $user, Keyword $keyword): bool
    {
        return $user->client->id === $keyword->order->client_id;
    }
}
