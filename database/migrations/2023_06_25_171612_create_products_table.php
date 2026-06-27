<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 300);
            $table->string('slug', 500);
            $table->string('code', 20)->nullable();
            $table->text('desc_quick')->nullable();
            $table->text('desc_detail')->nullable();
            $table->string('thumb_main');
            $table->string('thumb_detail');
            $table->unsignedBigInteger('creator');
            $table->decimal('discount', 5, 0)->nullable();
            $table->integer('amount');
            $table->decimal('old_price', 10, 0)->default(false);
            $table->decimal('new_price', 10, 0)->default(false);
            $table->integer('views')->default(0);
            $table->integer('purchases')->default(0);
            $table->unsignedBigInteger('cat_id');
            $table->boolean('featured_products')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->foreign('creator')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('cat_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
