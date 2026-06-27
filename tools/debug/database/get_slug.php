<?php
require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=devchampion', 'root', '');
    
    $stmt = $pdo->query('SELECT slug FROM products ORDER BY id LIMIT 1');
    echo "Product slug: " . $stmt->fetchColumn() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
