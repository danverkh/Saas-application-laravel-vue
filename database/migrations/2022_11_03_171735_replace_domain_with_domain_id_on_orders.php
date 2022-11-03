<?php

use App\Models\Domain;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('domain_id')->nullable()->after('user_id')->constrained();
        });

        Order::all()
             ->each(static function (Order $order) {
                $domain = Domain::firstOrCreate(['name' => $order->domain]);

                $order->forceFill(['domain_id' => $domain->id])->save();
             });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('domain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->string('domain')->after('user_id');
        });

        Order::with('domain')
             ->all()
             ->each(static function (Order $order) {
                 $order->forceFill(['domain' => $order->domain->name])->save();
             });

        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn('domain_id');
        });
    }
};
