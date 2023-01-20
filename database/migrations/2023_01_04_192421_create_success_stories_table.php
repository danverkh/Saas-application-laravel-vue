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
        Schema::create('success_stories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('client_id')->primary();
            $table->string('client_industry');
            $table->string('client_country');
            $table->string('client_city');
            $table->decimal('monthly_fee', 10, 2, true);
            $table->jsonb('keywords');
            $table->jsonb('chart');
            $table->date('campaign_active_since');
            $table->unsignedDecimal('ctr');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('success_stories');
    }
};
