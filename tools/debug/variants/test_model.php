<?php
// Test Laravel model directly
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $product = \App\Product::where('slug', 'adidas-x-crazyfast-3-tf')->first();
    if ($product) {
        echo "Found: " . $product->name . "\n";
        echo "Slug: " . $product->slug . "\n";
        echo "Colors: " . $product->colors()->count() . "\n";
        echo "Variants: " . $product->variants()->count() . "\n";
    } else {
        echo "Product not found\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
