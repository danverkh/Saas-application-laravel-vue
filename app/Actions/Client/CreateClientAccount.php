<?php

namespace App\Actions\Client;

use App\Events\ClientAccountCreated;
use App\Models\Client;
use App\Models\ClientAccount;

class CreateClientAccount
{
    /**
     * @param array $data
     *
     * @return \App\Models\ClientAccount
     */
    public static function handle(array $data): ClientAccount
    {
        $client = Client::create([
            'email'            => $data['email'],
            'name'             => $data['name'] ?? $data['email'],
            'accounting_email' => '', // TODO: what about this? It cannot be null
            'employee_id'      => 0, // TODO: what about this? It cannot be null
        ]);

        $clientAccount = ClientAccount::create([
            ...$data,
            'client_id' => $client->id,
            'language'  => 'en', // TODO: what about this? It cannot be null
        ]);

        ClientAccountCreated::dispatch($clientAccount);

        return $clientAccount;
    }
}
