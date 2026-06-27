<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Color;
use App\Models\Config;

class SyncProductColorsAndConfigs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:sync-colors-configs {--product-id=} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-sync colors and configs (sizes) to products from their catalog';

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
        $all = $this->option('all');
        $productId = $this->option('product-id');

        if ($all) {
            $this->syncAllProducts();
        } elseif ($productId) {
            $this->syncSingleProduct($productId);
        } else {
            $this->info('Dùng cách sau:');
            $this->line('  php artisan products:sync-colors-configs --all');
            $this->line('  php artisan products:sync-colors-configs --product-id=75');
            return 0;
        }

        return 0;
    }

    /**
     * Sync all products
     */
    protected function syncAllProducts()
    {
        $this->info('Đang đồng bộ tất cả sản phẩm...');

        $products = Product::all();
        $synced = 0;

        foreach ($products as $product) {
            if ($this->syncProductColorsConfigs($product)) {
                $synced++;
            }
        }

        $this->info("\n✓ Đã đồng bộ {$synced} sản phẩm");
    }

    /**
     * Sync single product
     */
    protected function syncSingleProduct($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            $this->error("Không tìm thấy sản phẩm #{$productId}");
            return;
        }

        if ($this->syncProductColorsConfigs($product)) {
            $this->info("✓ Đã đồng bộ sản phẩm #{$productId}: {$product->name}");
        } else {
            $this->warn("⊘ Không có gì để đồng bộ cho sản phẩm #{$productId}");
        }
    }

    /**
     * Sync colors and configs for a single product
     */
    protected function syncProductColorsConfigs(Product $product)
    {
        $changed = false;

        // Get all colors from the color catalog
        $colors = Color::where('status', 1)->get();
        $configuredColors = $product->colors()->pluck('colors.id')->toArray();

        // If product has no colors, try to sync based on category or other criteria
        if (empty($configuredColors) && count($colors) > 0) {
            // Add first 3 popular colors to product
            foreach ($colors->take(3) as $color) {
                if (!$product->colors()->where('color_id', $color->id)->exists()) {
                    $product->colors()->attach($color->id);
                    $changed = true;
                }
            }
        }

        // Get all configs (sizes) from the catalog
        $configs = Config::where('status', 1)->get();
        $configuredConfigs = $product->configs()->pluck('configs.id')->toArray();

        // If product has no configs, try to sync based on category
        if (empty($configuredConfigs) && count($configs) > 0) {
            // Add common sizes to product
            $commonSizeIds = [4, 5, 6]; // Size 38, 39, 40
            foreach ($configs as $config) {
                if (in_array($config->id, $commonSizeIds)) {
                    if (!$product->configs()->where('config_id', $config->id)->exists()) {
                        // Use default price for this product
                        $product->configs()->attach($config->id, ['price' => $product->new_price]);
                        $changed = true;
                    }
                }
            }
        }

        return $changed;
    }
}
