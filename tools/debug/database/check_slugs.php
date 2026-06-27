<?php
require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=devchampion', 'root', '');
    
    echo "Checking slugs in database:\n";
    $stmt = $pdo->query("SELECT id, name, slug FROM products WHERE id IN (1, 2, 3) ORDER BY id");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $p) {
        echo "ID: " . $p['id'] . "\n";
        echo "  Name: " . $p['name'] . "\n";
        echo "  Slug: '" . $p['slug'] . "'\n";
        echo "  Slug length: " . strlen($p['slug']) . "\n";
        echo "  Slug hex: " . bin2hex($p['slug']) . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
