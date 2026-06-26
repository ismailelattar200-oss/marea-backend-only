<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$orders = \DB::select('SELECT id, order_number, status FROM orders WHERE assigned_to IS NOT NULL');
$deliveries = \DB::select('SELECT id, order_id, status FROM deliveries');

echo json_encode([
    'orders' => $orders,
    'deliveries' => $deliveries
], JSON_PRETTY_PRINT);
