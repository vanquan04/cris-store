<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePromotionSubscribersForSupportRequests extends Migration
{
    public function up()
    {
        Schema::table('promotion_subscribers', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->string('request_type', 30)->default('support')->after('phone');
            $table->text('support_content')->nullable()->after('request_type');
        });
    }

    public function down()
    {
        Schema::table('promotion_subscribers', function (Blueprint $table) {
            $table->dropColumn(['request_type', 'support_content']);
            $table->unique('email');
        });
    }
}
