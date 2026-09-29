<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h2>🧹 Limpando cache... </h2>";

$kernel->call('cache:clear');
echo "<p>✅ Cache limpo</p>";

$kernel->call('config:clear');
echo "<p>✅ Config limpo</p>";

$kernel->call('view:clear');
echo "<p>✅ Views limpo</p>";

$kernel->call('route:clear');
echo "<p>✅ Routes limpo</p>";

echo "<h2>✅ TUDO LIMPO!</h2>";
echo "<p><a href='../'>Voltar ao login</a></p>";
?>
