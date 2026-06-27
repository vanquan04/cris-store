<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('slug', 500);
            $table->text('content');
            $table->string('content_demo', 500);
            $table->string('thumb_main', 500);
            $table->unsignedBigInteger('cat_parent');
            $table->unsignedBigInteger('creator');
            $table->foreign('cat_parent')->references('id')->on('cat_blogs')->onDelete('cascade');
            $table->foreign('creator')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('blogs');
    }
}
