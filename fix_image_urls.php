<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$models = [
    \App\Models\ButirSoal::class,
    \App\Models\ButirSoal2::class,
    \App\Models\ButirSoal3::class,
    \App\Models\ButirSoal4::class,
];

$search = 'http://127.0.0.1:8000/storage';
$replace = '/computer-assisted-test/public/storage';

foreach ($models as $model) {
    if (!class_exists($model)) continue;
    $items = $model::all();
    foreach ($items as $item) {
        $updated = false;
        $fields = ['soal', 'jawaban_a', 'jawaban_b', 'jawaban_c', 'jawaban_d', 'jawaban_e'];
        foreach ($fields as $field) {
            if (isset($item->$field) && strpos($item->$field, $search) !== false) {
                $item->$field = str_replace($search, $replace, $item->$field);
                $updated = true;
            }
        }
        if ($updated) {
            $item->save();
        }
    }
}
echo "Image URLs replaced successfully.";
