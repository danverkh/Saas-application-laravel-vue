<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::disableForeignKeyConstraints();

        DB::table('billing_addresses')->truncate();
        DB::table('keywords')->truncate();
        DB::table('users')->truncate();

        Schema::dropIfExists('keywords'); // autoranker_keywords
        Schema::dropIfExists('orders'); // orders
        Schema::dropIfExists('domains'); // domains is a column on orders


        $file = file_get_contents(
            database_path('./schema/schema_partial.sql')
        );

        DB::unprepared($file);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // there is no going back
    }
};
