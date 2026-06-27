<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

function checkSyntax($file) {
    exec("php -l " . escapeshellarg($file), $output, $return_var);
    if ($return_var !== 0) {
        echo "Syntax error in $file\n";
        echo implode("\n", $output) . "\n";
    } else {
        echo "Syntax OK in $file\n";
    }
}

checkSyntax(__DIR__ . '/../app/Http/Controllers/CartController.php');
checkSyntax(__DIR__ . '/../app/Http/Controllers/PromotionController.php');
checkSyntax(__DIR__ . '/../app/Http/Controllers/ForgotPasswordController.php');
