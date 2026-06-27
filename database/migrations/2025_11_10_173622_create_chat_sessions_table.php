<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable()->comment('Tên khách hàng');
            $table->string('user_phone', 20)->nullable()->comment('Số điện thoại khách hàng');
            $table->string('ip_address', 45)->nullable()->comment('Địa chỉ IP khách');
            $table->enum('status', ['active', 'ended'])->default('active')->comment('Trạng thái hội thoại');
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
    Schema::dropIfExists('chat_sessions');
    }
}
