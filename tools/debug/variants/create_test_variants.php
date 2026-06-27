<?php
require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=devchampion', 'root', '');
    
    // Get first product and its colors
    $stmt = $pdo->query('SELECT id FROM products LIMIT 1');
    $productId = $stmt->fetchColumn();
    
    // Get colors for this product
    $stmt = $pdo->prepare('SELECT color_id FROM product_color WHERE product_id = ?');
    $stmt->execute([$productId]);
    $colors = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Get some configs (sizes)
    $stmt = $pdo->query('SELECT id FROM configs ORDER BY id LIMIT 3');
    $sizes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Creating variants for product $productId\n";
    echo "Colors: " . implode(', ', $colors) . "\n";
    echo "Sizes: " . implode(', ', $sizes) . "\n";
    
    // Create variants
    $insertStmt = $pdo->prepare('INSERT IGNORE INTO product_variants (product_id, color_id, config_id, price, stock, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())');
    
    $variantsCreated = 0;
    foreach ($colors as $colorId) {
        foreach ($sizes as $sizeId) {
            $price = 1290000 + rand(0, 500000);
            $stock = rand(5, 50);
            $result = $insertStmt->execute([$productId, $colorId, $sizeId, $price, $stock]);
            if ($result) {
                $variantsCreated++;
                echo "  Created variant: Color=$colorId, Size=$sizeId, Price=$price, Stock=$stock\n";
            }
        }
    }
    
    echo "Total variants created: $variantsCreated\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
