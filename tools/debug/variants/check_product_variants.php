<?php
require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=db;port=3306;dbname=devchampion', 'root', '');
    
    // Find product by slug
    $stmt = $pdo->prepare("SELECT id, name, slug FROM products WHERE slug LIKE ? AND deleted_at IS NULL");
    $stmt->execute(['%nike-air-zoom-112%']);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        echo "Product not found\n";
        exit;
    }
    
    echo "Product: {$product['name']} (ID: {$product['id']})\n";
    
    // Check colors
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM product_color WHERE product_id = ?');
    $stmt->execute([$product['id']]);
    $colorCount = $stmt->fetchColumn();
    echo "Colors linked: $colorCount\n";
    
    // Check variants
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM product_variants WHERE product_id = ?');
    $stmt->execute([$product['id']]);
    $variantCount = $stmt->fetchColumn();
    echo "Variants created: $variantCount\n";
    
    if ($variantCount > 0) {
        $stmt = $pdo->prepare('SELECT pv.*, c.name FROM product_variants pv JOIN colors c ON pv.color_id = c.id WHERE pv.product_id = ? LIMIT 5');
        $stmt->execute([$product['id']]);
        $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Variant details:\n";
        foreach ($variants as $v) {
            echo "  Color: {$v['name']}, Size: {$v['config_id']}, Price: {$v['price']}, Stock: {$v['stock']}\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
