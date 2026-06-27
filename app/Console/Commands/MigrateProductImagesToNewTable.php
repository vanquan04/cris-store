<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductImage;

class MigrateProductImagesToNewTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:migrate-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing product images from thumb_main/thumb_detail to the new product_images table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting product image migration...');

        $products = Product::all();
        $totalMigrated = 0;
        $totalSkipped = 0;

        foreach ($products as $product) {
            $migrated = false;

            // Check if this product already has images in new table
            $existingImages = ProductImage::where('product_id', $product->id)->count();
            if ($existingImages > 0) {
                $this->line("⊘ Sản phẩm #{$product->id} ({$product->name}) - đã có ảnh trong bảng mới, bỏ qua");
                $totalSkipped++;
                continue;
            }

            // Migrate thumb_main
            if ($product->thumb_main && $product->thumb_main !== 'null') {
                ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => null,
                    'config_id' => null,
                    'image_path' => $product->thumb_main,
                    'display_order' => 0,
                    'is_main' => true,
                ]);
                $migrated = true;
            }

            // Migrate thumb_detail
            if ($product->thumb_detail && $product->thumb_detail !== 'null') {
                $detailImages = json_decode($product->thumb_detail, true);
                if (is_array($detailImages)) {
                    $order = 1;
                    foreach ($detailImages as $imagePath) {
                        if ($imagePath && $imagePath !== 'null') {
                            ProductImage::create([
                                'product_id' => $product->id,
                                'color_id' => null,
                                'config_id' => null,
                                'image_path' => $imagePath,
                                'display_order' => $order,
                                'is_main' => false,
                            ]);
                            $order++;
                            $migrated = true;
                        }
                    }
                }
            }

            if ($migrated) {
                $imageCount = ProductImage::where('product_id', $product->id)->count();
                $this->line("✓ Sản phẩm #{$product->id} ({$product->name}) - {$imageCount} ảnh");
                $totalMigrated++;
            } else {
                $this->line("⊘ Sản phẩm #{$product->id} ({$product->name}) - không có ảnh để migrate");
                $totalSkipped++;
            }
        }

        $this->info("\n=== Migration hoàn thành ===");
        $this->info("✓ Đã migrate: {$totalMigrated} sản phẩm");
        $this->info("⊘ Bỏ qua: {$totalSkipped} sản phẩm");

        return 0;
    }
}
