<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndUserToPromotionSubscribers extends Migration
{
    public function up()
    {
        Schema::table('promotion_subscribers', function (Blueprint $table) {
            $table->string('status', 20)->default('new')->after('support_content');
            $table->unsignedBigInteger('user_id')->nullable()->after('status');
            $table->index('status');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('promotion_subscribers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id']);
            $table->dropColumn(['status', 'user_id']);
        });
    }
}
