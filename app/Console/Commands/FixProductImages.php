<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class FixProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:fix-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix missing product images by assigning placeholder images';

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
        // Available image sets
        $availableImages = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];

        // Get all products without images
        $products = Product::where(function ($query) {
            $query->whereNull('thumb_main')
                ->orWhere('thumb_main', '')
                ->orWhere('thumb_main', 'null');
        })->get();

        $this->info('Found ' . count($products) . ' products without images');

        $count = 0;
        foreach ($products as $index => $product) {
            $imageSetNum = $availableImages[$index % count($availableImages)];
            
            // Build thumbnail paths
            $thumbMain = 'uploads/sp' . $imageSetNum . '-main.jpg';
            $thumbDetails = [];
            
            // Add available detail images
            for ($i = 1; $i <= 4; $i++) {
                $detailPath = 'uploads/sp' . $imageSetNum . '-detail' . $i . '.jpg';
                $thumbDetails[] = $detailPath;
            }
            
            // Update product
            $product->update([
                'thumb_main' => $thumbMain,
                'thumb_detail' => json_encode($thumbDetails),
            ]);
            
            $count++;
            $this->line("✓ Updated: {$product->name} (sp{$imageSetNum})");
        }

        $this->info("\n✓ Successfully updated {$count} products with images!");

        return 0;
    }
}
