<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_has_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->foreignId('language_id');
        });

        $raw = File::get(database_path('seeders/data/countries.json'));

        $countries = json_decode($raw, false, 512, JSON_THROW_ON_ERROR);

        $pivot = [];

        collect($countries)
            ->map(static function ($country) use (&$pivot) {
                foreach (data_get($country, 'languages', []) as $languageCode) {
                    try {
                        $pivot[] = [
                            'country_id'  => DB::table('countries')->where('iso2', $country->iso2)->first()->id,
                            'language_id' => DB::table('languages')->where('code', $languageCode)->first()->id,
                        ];
                    } catch (\Exception $e) {
                        echo "\n    ! Failed to get lang: {$languageCode} or country: {$country->iso2}";
                    }
                }
            });

        DB::table('country_has_language')->insert($pivot);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_has_language');
    }
};
