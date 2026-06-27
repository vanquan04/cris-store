<?php
require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=db;port=3306;dbname=devchampion', 'root', '');
    
    // Check products including deleted
    $stmt = $pdo->query('SELECT id, name, slug, deleted_at FROM products ORDER BY id LIMIT 5');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Products in database:\n";
    foreach ($products as $p) {
        $status = $p['deleted_at'] ? "DELETED" : "ACTIVE";
        echo "ID: {$p['id']}, Name: {$p['name']}, Slug: {$p['slug']}, Status: $status\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
