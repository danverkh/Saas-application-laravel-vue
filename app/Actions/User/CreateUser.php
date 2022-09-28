<?php

namespace App\Actions\User;

use App\Events\UserCreated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        $user = User::create([
            'email'    => $email,
            'password' => Hash::make($password),
        ]);

        UserCreated::dispatch($user, $password);

        return $user;
    }
}
