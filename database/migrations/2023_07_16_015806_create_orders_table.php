<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('fullname', 255);
            $table->string('address');
            $table->string('phone', 20);
            $table->string('note')->nullable();
            $table->string('email');
            $table->text('product');
            $table->integer('amount');
            $table->decimal('total', 10, 0)->default(false);
            $table->boolean('method_pay')->default(false);
            $table->string('code_bill');
            $table->integer('progress')->default(false);
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
