<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap kernel for Eloquent
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Str;
$models = [
    'App\\Blog',
    'App\\Cat_blog',
    'App\\Cat_product',
    'App\\Product',
    'App\\Page',
    'App\\Promotion',
    'App\\Color',
];
foreach ($models as $m) {
    if (!class_exists($m)) continue;
    try {
        $count = 0;
        $rows = $m::whereRaw("slug RLIKE '[^a-z0-9-]'")->get();
        foreach ($rows as $r) {
            if (isset($r->name) && $r->name) {
                $r->slug = Str::slug($r->name);
                $r->save();
                $count++;
            }
        }
        echo "$m: updated $count rows\n";
    } catch (\Exception $e) {
        echo "$m: error - " . $e->getMessage() . "\n";
    }
}
