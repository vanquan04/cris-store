<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\User;
use Illuminate\Support\Facades\Hash;
$u = User::where('username', 'admin_test')->first();
if ($u) {
    echo "FOUND\n";
    echo "OLD_PASSWORD_HASH={$u->password}\n";
    $u->password = Hash::make('admin123');
    $u->save();
    echo "UPDATED_PASSWORD_HASH={$u->password}\n";
    echo "CHECK=" . (Hash::check('admin123', $u->password) ? 'TRUE' : 'FALSE') . "\n";
} else {
    echo "NOT FOUND\n";
}
