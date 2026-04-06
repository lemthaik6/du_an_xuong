<?php
// Test script đơn giản
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kiểm tra Laragon có đang chạy không
echo "=== KIỂM TRA CẤU HÌNH ===\n\n";

// 1. Kiểm tra PHP version
echo "✅ PHP Version: " . phpversion() . "\n";

// 2. Kiểm tra các files quan trọng
$files = [
    'public/index.php' => 'Entry point',
    'src/Database.php' => 'Database class',
    'app/Controllers/DashboardController.php' => 'Dashboard Controller',
    'views/dashboard/customer.php' => 'Customer Dashboard View',
    'views/auth/register.php' => 'Register View'
];

echo "\n📁 Kiểm tra files:\n";
foreach ($files as $file => $desc) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✅ $desc ($file)\n";
    } else {
        echo "❌ MISSING: $desc ($file)\n";
    }
}

// 3. Kiểm tra vendor autoload
echo "\n📦 Kiểm tra Composer:\n";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "✅ Composer autoload\n";
    require_once __DIR__ . '/vendor/autoload.php';
    echo "✅ Autoload loaded\n";
} else {
    echo "❌ Composer autoload không tìm thấy\n";
}

// 4. Hướng dẫn test
echo "\n🚀 HƯỚNG DẪN ĐỂ TEST:\n";
echo "1. Mở trình duyệt: http://localhost/du_an_xuong/public/login\n";
echo "2. Nếu muốn tạo customer mới, click 'Đăng Ký'\n";
echo "3. Chọn 'Khách Hàng (Customer)' trong phần 'Loại Tài Khoản'\n";
echo "4. Điền form và đăng ký\n";
echo "5. Quay lại login và đăng nhập\n";
echo "6. Bạn sẽ thấy Dashboard Customer với:\n";
echo "   - Danh sách sản phẩm (chỉ xem, không mua)\n";
echo "   - Form liên hệ admin dưới cùng\n\n";

echo "⚠️ LƯU Ý:\n";
echo "- Phải có sản phẩm trong database (bảng products)\n";
echo "- Database phải chạy (MySOL/MariaDB)\n";
echo "- Laragon phải start Apache + MySQL\n\n";

echo "✅ Setup hoàn tất! Hãy test qua trình duyệt.\n";
?>
