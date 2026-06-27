<?php
require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=devchampion', 'root', '');
    
    $stmt = $pdo->query('SELECT id, name, slug FROM products ORDER BY id LIMIT 5');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $p) {
        echo "ID: {$p['id']}, Name: {$p['name']}, Slug: {$p['slug']}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
