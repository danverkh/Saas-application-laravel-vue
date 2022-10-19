<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso2');
            $table->string('iso3');
            $table->string('tld');
        });

        $raw = File::get(database_path('seeders/data/countries.json'));

        $countries = json_decode($raw, false, 512, JSON_THROW_ON_ERROR);

        DB::table('countries')->insert(
            collect($countries)
                ->map(static function ($country) {
                    return [
                        'name' => $country->name,
                        'iso2' => $country->iso2,
                        'iso3' => $country->iso3,
                        'tld'  => Str::substr($country->tld, 1),
                    ];
                })
                ->toArray()
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
