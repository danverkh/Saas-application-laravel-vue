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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
        });

        $raw = File::get(database_path('seeders/data/languages.json'));

        $countries = json_decode($raw, false, 512, JSON_THROW_ON_ERROR);

        DB::table('languages')->insert(
            collect($countries)
                ->map(static function ($language) {
                    return [
                        'name'   => $language->name,
                        'code'   => $language->code,
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
        Schema::dropIfExists('languages');
    }
};
