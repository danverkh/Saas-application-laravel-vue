<?php

use App\Models\Order;
use App\Models\Keyword;
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
        Schema::table('order_keywords', function (Blueprint $table) {
            $table->foreignId('domain_id')->after('order_id')->nullable()->constrained();
        });

        Keyword::with('order')
               ->get()
               ->each(static function (Keyword $keyword) {
                $keyword->forceFill(['domain_id' => $keyword->order->domain_id])->save();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_keywords', function (Blueprint $table) {
            $table->dropConstrainedForeignId('domain_id');
        });
    }
};
