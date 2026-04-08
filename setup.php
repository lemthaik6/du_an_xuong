<?php
require_once 'vendor/autoload.php';
require_once 'src/Database.php';

$db = new \Src\Database();

echo "<h1>🔧 Khởi Tạo Database</h1>";

// Read and execute database_setup.sql
$sql = file_get_contents('database_setup.sql');

// Split by semicolon to get individual statements
$statements = array_filter(
    array_map('trim', explode(';', $sql)),
    function($s) { return !empty($s) && !str_starts_with($s, '--'); }
);

$success = 0;
$failed = 0;
$errors = [];

foreach ($statements as $statement) {
    if (empty(trim($statement))) continue;
    
    try {
        $result = $db->getConnection()->query($statement);
        echo "✅ Executed\n";
        $success++;
    } catch (Exception $e) {
        echo "⚠️ Statement error: " . $e->getMessage() . "\n";
        $failed++;
        $errors[] = $e->getMessage();
    }
}

echo "<h2>Kết Quả</h2>";
echo "<p>✅ Thành công: " . $success . " câu lệnh</p>";

if ($failed > 0) {
    echo "<p>⚠️ Lỗi: " . $failed . " câu lệnh</p>";
}

// Check final state
echo "<h2>Trạng Thái Database</h2>";

$productCount = $db->fetchOne("SELECT COUNT(*) as count FROM products");
$activeCount = $db->fetchOne("SELECT COUNT(*) as count FROM products WHERE status = 'active' AND stock > 0");

echo "<p>Total products: " . ($productCount['count'] ?? 0) . "</p>";
echo "<p>Active products: " . ($activeCount['count'] ?? 0) . "</p>";

if (($activeCount['count'] ?? 0) > 0) {
    echo "<p style='color: green;'>✅ Database ready! You can now view products at:</p>";
    echo "<p><a href='public/shop' style='color: blue;'>View Products</a></p>";
}
?>
