<?php

namespace App\Actions\User;

use App\Events\UserCreated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser
{
    /**
     * @param string $email
     *
     * @return \App\Models\User
     */
    public static function handle(string $email): User
    {
        $password = generateStrongPassword(8);

        $user = User::forceCreate([
            'email'      => $email,
            'password'   => Hash::make($password),
            'login_hash' => Str::random(64),
        ]);

        UserCreated::dispatch($user, $password);

        return $user;
    }
}
