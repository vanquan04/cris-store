<?php
/**
 * Fix missing product images
 * Script to assign placeholder images to products that don't have thumbnails
 * Run: php tools/fix_product_images.php
 */

// Include Laravel bootstrap
require __DIR__ . '/../bootstrap/app.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Product;
use Illuminate\Support\Facades\DB;

// Available image sets
$availableImages = [
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14
];

// Get all products
$products = Product::whereNull('thumb_main')
    ->orWhere('thumb_main', '')
    ->orWhere('thumb_main', 'null')
    ->get();

echo "Found " . count($products) . " products without images\n";

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
    echo "✓ Updated product #{$product->id}: {$product->name} -> sp{$imageSetNum}\n";
}

echo "\n✓ Successfully updated {$count} products with images!\n";
