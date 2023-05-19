<?php

namespace App\Actions\Client;

use App\Events\ClientAccountCreated;
use App\Models\Client;
use App\Models\ClientAccount;
use Illuminate\Support\Facades\DB;
use Str;

class CreateClientAccount
{
    /**
     * @param array $data
     *
     * @return \App\Models\ClientAccount
     */
    public static function handle(array $data): ClientAccount
    {
        $name = $data['email'];

        if (!isset($data['name'])) {
            $domain = Str::after($data['email'], '@');

            $row = DB::table('prospect_mail_domains')
                     ->where('company', $domain)
                     ->orWhere('mail_domain', $domain)
                     ->first();

            if ($row) {
                $name = $row->title;
            }
        }
        $client = Client::create([
            'email'            => $data['email'],
            'name'             => $name,
            'accounting_email' => $data['email'],
            'employee_id'      => 120,
        ]);

        $clientAccount = ClientAccount::create([
            ...$data,
            'client_id' => $client->id,
            'language'  => 'en',
        ]);

        ClientAccountCreated::dispatch($clientAccount);

        return $clientAccount;
    }
}
