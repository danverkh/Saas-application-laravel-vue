<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GenerateDomainSuggestionsJsonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:domain-suggestions-json-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will generate or update domain suggestions json file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rows = DB::select("SELECT mail_domain AS domain
           FROM
             (SELECT mail_domain,
                          @domain_count := IF(@current_domain = SUBSTRING(mail_domain, 1, 2), @domain_count + 1, 1) AS domain_count,
                          @current_domain := SUBSTRING(mail_domain, 1, 2)
               FROM prospect_mail_domains
             ) ranked
           WHERE domain_count <= 4;");

        $rows = collect($rows)
            ->pluck('domain')
            ->filter(static fn($domain) => strlen($domain) > 3)
            ->values();

        File::put(public_path('data/initial_domain_suggestions.json'), $rows->toJson());

        return 0;
    }
}
