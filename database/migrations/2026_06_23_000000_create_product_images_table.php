<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('color_id')->nullable(); // If null, applies to all colors
            $table->unsignedBigInteger('config_id')->nullable(); // If null, applies to all sizes
            $table->string('image_path'); // Path like: uploads/filename.jpg
            $table->integer('display_order')->default(0); // For sorting multiple images
            $table->boolean('is_main')->default(false); // Mark as main/thumbnail
            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade');

            $table->foreign('config_id')
                ->references('id')
                ->on('configs')
                ->onDelete('cascade');

            // Indexes for performance
            $table->index('product_id');
            $table->index(['product_id', 'color_id']);
            $table->index(['product_id', 'config_id']);
            $table->index(['product_id', 'color_id', 'config_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}
