<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CatProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['adidas', 'nike', 'puma', 'mizuno', 'wika'];

        foreach ($names as $name) {
            $slug = Str::slug($name);
            $exists = DB::table('cat_products')->where('slug', $slug)->exists();
            if ($exists) {
                continue;
            }

            DB::table('cat_products')->insert([
                'name' => ucfirst($name),
                'slug' => $slug,
                'parent_id' => 0,
                'creator' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
