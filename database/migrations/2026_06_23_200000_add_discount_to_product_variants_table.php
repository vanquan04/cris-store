<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToProductVariantsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('product_variants') && !Schema::hasColumn('product_variants', 'discount')) {
            Schema::table('product_variants', function (Blueprint $table) {
                $table->integer('discount')->default(0)->comment('Discount percentage for this variant');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('product_variants') && Schema::hasColumn('product_variants', 'discount')) {
            Schema::table('product_variants', function (Blueprint $table) {
                $table->dropColumn('discount');
            });
        }
    }
}
