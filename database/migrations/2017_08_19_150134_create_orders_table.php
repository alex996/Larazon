<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('card_id');
            $table->unsignedInteger('address_id');
            $table->enum('status', [
                'pending', 'canceled', 'shipping', 'completed'
            ]);
            $table->unsignedDecimal('subtotal', 9, 2);
            $table->unsignedDecimal('shipping', 9, 2);
            $table->unsignedDecimal('tax', 9, 2);
            $table->unsignedDecimal('total', 9, 2);
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
