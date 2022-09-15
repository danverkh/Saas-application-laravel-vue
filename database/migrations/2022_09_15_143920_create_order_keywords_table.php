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
        Schema::create('order_keywords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->text('keyword');
            $table->unsignedInteger('search_volume')->nullable();
            $table->unsignedDouble('cpc')->nullable();
            $table->unsignedDouble('competition')->nullable();
            $table->integer('current_rank')->nullable();
            $table->unsignedDouble('maximum_cost')->nullable();
            $table->unsignedDecimal('projected_clicks')->nullable();
            $table->unsignedDecimal('projected_traffic')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_keywords');
    }
};
