<?php
// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: /du_an_xuong/public/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Khách Hàng</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .user-info {
            text-align: right;
        }

        .user-info p {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .logout-btn {
            background: #f44336;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #da190b;
        }

        .nav-links {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .nav-link {
            background: white;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            color: #667eea;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-link:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome-section h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .feature-box {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .feature-box h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .feature-box p {
            color: #666;
            font-size: 14px;
        }

        .products-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .products-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #999;
            font-weight: bold;
        }

        .product-content {
            padding: 15px;
        }

        .product-name {
            color: #333;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .product-description {
            color: #666;
            font-size: 13px;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-price {
            color: #667eea;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .contact-btn {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            transition: background 0.3s;
        }

        .contact-btn:hover {
            background: #45a049;
        }

        .contact-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .contact-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .contact-form {
            display: grid;
            gap: 15px;
            max-width: 600px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        .submit-btn {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #5568d3;
        }

        .no-products {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .footer {
            text-align: center;
            color: white;
            padding: 20px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            .user-info {
                text-align: center;
                margin-top: 15px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .contact-form {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>👋 Chào Mừng Khách Hàng</h1>
                <p><?php echo date('d/m/Y H:i'); ?></p>
            </div>
            <div class="user-info">
                <p><?php echo htmlspecialchars($user['full_name'] ?? $user['username'] ?? 'Khách'); ?></p>
                <a href="/du_an_xuong/public/profile" class="logout-btn" style="background: #2196F3; margin-right: 10px;">Cài Đặt Tài Khoản</a>
                <a href="/du_an_xuong/public/logout" class="logout-btn">Đăng Xuất</a>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="nav-links">
            <a href="#san-pham" class="nav-link">📦 Xem Sản Phẩm</a>
            <a href="#lien-he" class="nav-link">📞 Liên Hệ Admin</a>
            <a href="/du_an_xuong/public/profile" class="nav-link">👤 Hồ Sơ Cá Nhân</a>
        </div>

        <!-- Welcome Section -->
        <div class="welcome-section">
            <h2>Trang Khách Hàng</h2>
            <p>Xin chào! Bạn là khách hàng của hệ thống quản lý dự án của chúng tôi. Tại đây bạn có thể:</p>
            <div class="features">
                <div class="feature-box">
                    <h3>📦 Xem Sản Phẩm</h3>
                    <p>Khám phá danh sách sản phẩm mà công ty chúng tôi cung cấp</p>
                </div>
                <div class="feature-box">
                    <h3>💬 Liên Hệ Admin</h3>
                    <p>Nếu bạn muốn mua hoặc có câu hỏi, liên hệ trực tiếp với admin</p>
                </div>
                <div class="feature-box">
                    <h3>👤 Quản Lý Tài Khoản</h3>
                    <p>Cập nhật thông tin cá nhân của bạn</p>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="products-section" id="san-pham">
            <h2>📦 Danh Sách Sản Phẩm</h2>
            <?php if (!empty($products) && is_array($products)): ?>
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <span>Hình Ảnh Sản Phẩm</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-content">
                                <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                                <div class="product-description"><?php echo htmlspecialchars(substr($product['description'] ?? 'Không có mô tả', 0, 80)); ?>...</div>
                                <div class="product-price">
                                    <?php 
                                        $price = $product['price'] ?? 0;
                                        echo number_format($price, 0, ',', '.') . ' VNĐ';
                                    ?>
                                </div>
                                <button class="contact-btn" onclick="document.location.href='#lien-he'">💬 Liên Hệ Để Mua</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-products">
                    <p>Hiện chưa có sản phẩm. Vui lòng quay lại sau!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Contact Button -->
        <div style="text-align: center; margin: 40px 0;">
            <button onclick="toggleContactForm()" class="submit-btn" style="padding: 15px 40px; font-size: 16px; background: #4CAF50;">
                📞 Liên Hệ Admin Để Mua Sản Phẩm
            </button>
        </div>

        <!-- Contact Section (Hidden by default) -->
        <div class="contact-section" id="lien-he" style="display: none;">
            <h2>📞 Liên Hệ Admin Để Mua Sản Phẩm</h2>
            <p style="color: #666; margin-bottom: 20px;">Nếu bạn quan tâm đến sản phẩm nào, vui lòng điền form dưới đây để liên hệ trực tiếp với admin</p>
            
            <?php if (isset($_GET['success'])): ?>
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    ✅ Tin nhắn của bạn đã được gửi thành công! Admin sẽ liên hệ với bạn sớm.
                </div>
            <?php endif; ?>

            <form method="POST" action="/du_an_xuong/public/contact/send" class="contact-form">
                <div class="form-group">
                    <label for="name">Tên của Bạn *</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="subject">Chủ Đề *</label>
                    <input type="text" id="subject" name="subject" placeholder="Ví dụ: Muốn tìm hiểu về sản phẩm X" required>
                </div>

                <div class="form-group">
                    <label for="message">Nội Dung Tin Nhắn *</label>
                    <textarea id="message" name="message" placeholder="Nhập nội dung của bạn..." required></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="submit-btn" style="flex: 1;">Gửi Tin Nhắn</button>
                    <button type="button" onclick="toggleContactForm()" class="submit-btn" style="flex: 1; background: #f44336;">Đóng</button>
                </div>
            </form>
        </div>

        <script>
            function toggleContactForm() {
                const form = document.getElementById('lien-he');
                if (form.style.display === 'none') {
                    form.style.display = 'block';
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    form.style.display = 'none';
                }
            }
        </script>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2026 Hệ Thống Quản Lý Dự Án. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
