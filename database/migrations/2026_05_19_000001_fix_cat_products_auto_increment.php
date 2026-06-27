<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixCatProductsAutoIncrement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ensure primary key exists and set id to AUTO_INCREMENT with next value > max(id)
        $max = DB::table('cat_products')->max('id');
        if (is_null($max)) {
            $next = 1;
        } else {
            $next = $max + 1;
        }

        DB::statement('ALTER TABLE `cat_products` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;');
        DB::statement('ALTER TABLE `cat_products` AUTO_INCREMENT = ' . intval($next) . ';');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove AUTO_INCREMENT if needed
        DB::statement('ALTER TABLE `cat_products` MODIFY `id` bigint(20) UNSIGNED NOT NULL;');
    }
}
