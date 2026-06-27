<?php
require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=devchampion', 'root', '');
    
    // Check products
    $stmt = $pdo->query('SELECT COUNT(*) FROM products');
    echo "Total products: " . $stmt->fetchColumn() . "\n";
    
    // Check first product
    $stmt = $pdo->query('SELECT id, name FROM products ORDER BY id LIMIT 1');
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        echo "First product: " . $product['name'] . " (ID: " . $product['id'] . ")\n";
        
        // Check product colors
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM product_color WHERE product_id = ?');
        $stmt->execute([$product['id']]);
        $colorCount = $stmt->fetchColumn();
        echo "Colors linked: $colorCount\n";
        
        if ($colorCount > 0) {
            $stmt = $pdo->prepare('SELECT pc.*, c.name FROM product_color pc JOIN colors c ON pc.color_id = c.id WHERE pc.product_id = ?');
            $stmt->execute([$product['id']]);
            $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($colors as $color) {
                echo "  - Color: " . $color['name'] . " (ID: " . $color['color_id'] . ")\n";
            }
        }
        
        // Check product variants
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM product_variants WHERE product_id = ?');
        $stmt->execute([$product['id']]);
        $variantCount = $stmt->fetchColumn();
        echo "Variants created: $variantCount\n";
        
        if ($variantCount > 0) {
            $stmt = $pdo->prepare('SELECT pv.*, c.name as color_name FROM product_variants pv JOIN colors c ON pv.color_id = c.id WHERE pv.product_id = ? LIMIT 5');
            $stmt->execute([$product['id']]);
            $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($variants as $variant) {
                echo "  - Variant: Color=" . $variant['color_name'] . ", Size=" . $variant['config_id'] . ", Price=" . $variant['price'] . ", Stock=" . $variant['stock'] . "\n";
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
