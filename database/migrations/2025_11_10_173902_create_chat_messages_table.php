<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
              Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')
                  ->constrained('chat_sessions')
                  ->onDelete('cascade')
                  ->comment('Liên kết tới bảng chat_sessions');
            $table->enum('sender', ['user', 'bot'])->comment('Người gửi: user hoặc bot');
            $table->text('content')->comment('Nội dung tin nhắn');
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
        Schema::dropIfExists('chat_messages');
    }
}
