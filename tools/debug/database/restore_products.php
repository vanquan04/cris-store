<?php
require 'vendor/autoload.php';

try {
    $pdo = new PDO('mysql:host=db;port=3306;dbname=devchampion', 'root', '');
    
    // Restore all products
    $stmt = $pdo->query('UPDATE products SET deleted_at = NULL WHERE deleted_at IS NOT NULL');
    $count = $stmt->rowCount();
    
    echo "Restored $count products\n";
    
    // Verify
    $stmt = $pdo->query('SELECT COUNT(*) as active_count FROM products WHERE deleted_at IS NULL');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Active products now: " . $result['active_count'] . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
