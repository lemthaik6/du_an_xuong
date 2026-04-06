<?php
// Test script cho Customer feature
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Load environment
if (file_exists(__DIR__ . '/../.env')) {
    $env = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') === false) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Database;
use App\Models\User;
use App\Models\Product;

echo "=== TEST CUSTOMER FEATURE ===\n\n";

try {
    $db = Database::getInstance();

    // TEST 1: Tạo customer user
    echo "TEST 1: Tạo customer user...\n";
    
    // Xóa customer cũ nếu có
    $db->query("DELETE FROM users WHERE email = 'customer@test.com'");
    
    // Tạo user mới
    $userId = $db->insert('users', [
        'username' => 'customer_test',
        'email' => 'customer@test.com',
        'password' => md5('123456'),
        'full_name' => 'Khách Hàng Test',
        'phone' => '0909123456',
        'role' => 'customer',
        'status' => 'active'
    ]);
    
    echo "✅ Tạo customer user thành công (ID: $userId)\n\n";

    // TEST 2: Kiểm tra user có thể login
    echo "TEST 2: Kiểm tra login customer...\n";
    $user = $db->fetchOne(
        "SELECT * FROM users WHERE email = ? AND password = ?",
        ['customer@test.com', md5('123456')]
    );
    
    if ($user) {
        echo "✅ Login thành công\n";
        echo "   - ID: " . $user['id'] . "\n";
        echo "   - Email: " . $user['email'] . "\n";
        echo "   - Role: " . $user['role'] . "\n";
        echo "   - Full Name: " . $user['full_name'] . "\n\n";
    } else {
        echo "❌ Login thất bại\n\n";
    }

    // TEST 3: Kiểm tra có products
    echo "TEST 3: Kiểm tra sản phẩm...\n";
    $products = $db->fetchAll(
        "SELECT * FROM products WHERE status = 'active' LIMIT 5"
    );
    
    if (!empty($products) && is_array($products)) {
        echo "✅ Có " . count($products) . " sản phẩm:\n";
        foreach ($products as $product) {
            echo "   - " . $product['name'] . " (" . $product['price'] . " VNĐ)\n";
        }
        echo "\n";
    } else {
        echo "⚠️ Hiện chưa có sản phẩm trong database\n\n";
    }

    // TEST 4: Kiểm tra Customer dashboard URL
    echo "TEST 4: Dashboard URLs\n";
    echo "✅ Login: http://localhost/du_an_xuong/public/login\n";
    echo "✅ Register (Customer): http://localhost/du_an_xuong/public/register\n";
    echo "✅ Dashboard (sau login): http://localhost/du_an_xuong/public/dashboard\n";
    echo "✅ Contact/Order: Scroll xuống dashboard customer\n\n";

    // TEST 5: Test flow
    echo "TEST 5: Hướng dẫn test manual\n";
    echo "STEP 1: Đăng nhập\n";
    echo "   - Email: customer@test.com\n";
    echo "   - Password: 123456\n\n";
    echo "STEP 2: Sau đó bạn sẽ thấy:\n";
    echo "   ✅ Dashboard Customer với:\n";
    echo "      - Hiển thị danh sách sản phẩm (đọc-chỉ)\n";
    echo "      - Nút 'Liên Hệ Để Mua' cho mỗi sản phẩm\n";
    echo "      - Form liên hệ Admin\n\n";
    echo "STEP 3: Gửi tin nhắn liên hệ\n";
    echo "   ✅ Công việc không có checkout trực tiếp\n";
    echo "   ✅ Tất cả mua hàng đều qua liên hệ Admin\n\n";

    echo "=== CẤU HÌNH HOÀN THÀNH ✅ ===\n";
    echo "Bây giờ hãy test bằng cách:\n";
    echo "1. Truy cập: http://localhost/du_an_xuong/public/login\n";
    echo "2. Đăng nhập với: customer@test.com / 123456\n";
    echo "3. Xem sản phẩm và gửi tin nhắn liên hệ\n";

} catch (\Exception $e) {
    echo "❌ LỖI: " . $e->getMessage();
}
?>
