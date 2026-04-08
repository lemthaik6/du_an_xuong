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
            background: radial-gradient(circle at top left, rgba(99, 102, 241, 0.18), transparent 30%), linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 24px 16px;
            color: #1f2937;
        }

        .container {
            max-width: 1180px;
            margin: 0 auto;
        }

        .header {
            background: rgba(255, 255, 255, 0.96);
            padding: 28px 32px;
            border-radius: 28px;
            margin-bottom: 28px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(203, 213, 225, 0.75);
        }

        .header h1 {
            color: #0f172a;
            font-size: 34px;
            margin-bottom: 6px;
            font-weight: 800;
        }

        .header p {
            color: #475569;
            font-size: 14px;
        }

        .user-info {
            text-align: right;
        }

        .user-info p {
            color: #334155;
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 15px;
        }

        .logout-btn {
            background: #4f46e5;
            color: white;
            padding: 10px 22px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.25s ease;
            margin-left: 10px;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);
        }

        .logout-btn[style*="background: #2196F3"] {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
        }

        .logout-btn[style*="background: #f44336"], 
        .logout-btn[style*="f44336"] {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
        }

        .nav-links {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .nav-link {
            background: white;
            padding: 12px 24px;
            border-radius: 999px;
            text-decoration: none;
            color: #334155;
            font-weight: 700;
            transition: all 0.25s ease;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
            font-size: 14px;
            border: 1px solid rgba(148, 163, 184, 0.3);
        }

        .nav-link:hover {
            background: #4f46e5;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(79, 70, 229, 0.18);
        }

        .welcome-section {
            background: white;
            padding: 32px;
            border-radius: 26px;
            margin-bottom: 36px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .welcome-section h2 {
            color: #0f172a;
            margin-bottom: 14px;
            font-size: 30px;
            font-weight: 800;
        }

        .welcome-section p {
            color: #475569;
            line-height: 1.8;
            margin-bottom: 22px;
            font-size: 15px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .feature-box {
            background: #f8fafc;
            padding: 22px;
            border-radius: 22px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            transition: all 0.25s ease;
        }

        .feature-box:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
        }

        .feature-box h3 {
            color: #111827;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 700;
        }

        .feature-box p {
            color: #475569;
            font-size: 14px;
            line-height: 1.75;
        }

        .products-section {
            background: #ffffff;
            padding: 34px;
            border-radius: 28px;
            margin-bottom: 40px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .products-section h2 {
            color: #0f172a;
            margin-bottom: 30px;
            font-size: 32px;
            font-weight: 800;
            text-align: center;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 25px;
            padding: 10px 0;
        }

        .product-card {
            background: #f8fbff;
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 28px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.12);
        }

        .product-image {
            width: 100%;
            height: 240px;
            background: linear-gradient(180deg, #eef2ff 0%, #dbeafe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        }

        .product-image img {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-content {
            padding: 24px;
        }

        .product-name {
            color: #0f172a;
            font-weight: 800;
            margin-bottom: 10px;
            font-size: 18px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-description {
            color: #475569;
            font-size: 14px;
            margin-bottom: 16px;
            line-height: 1.75;
            min-height: 48px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            color: #2563eb;
            font-weight: 800;
            font-size: 20px;
            margin-bottom: 18px;
        }

        .product-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .detail-btn,
        .contact-btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.25s ease;
            font-size: 14px;
            text-decoration: none;
            min-width: 130px;
            white-space: nowrap;
        }

        .detail-btn {
            background: #3b82f6;
            box-shadow: 0 12px 25px rgba(59, 130, 246, 0.18);
        }

        .contact-btn {
            background: #14b8a6;
            box-shadow: 0 12px 25px rgba(20, 184, 166, 0.18);
            position: relative;
            overflow: hidden;
        }

        .detail-btn:hover {
            transform: translateY(-2px);
            background: #2563eb;
        }

        .contact-btn:hover {
            transform: translateY(-2px);
            background: #0f766e;
        }

        .contact-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.3s ease;
        }

        .contact-btn:hover::before {
            left: 100%;
        }

        .contact-section {
            background: #ffffff;
            padding: 36px;
            border-radius: 28px;
            margin-bottom: 40px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .contact-section h2 {
            color: #0f172a;
            margin-bottom: 16px;
            font-size: 30px;
            font-weight: 800;
        }

        .contact-section p {
            color: #475569;
            margin-bottom: 24px;
            line-height: 1.75;
            font-size: 15px;
        }

        .contact-form {
            display: grid;
            gap: 20px;
            max-width: 700px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            color: #334155;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .form-group input,
        .form-group textarea {
            padding: 14px 18px;
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.25s ease;
            background: #f8fafc;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 140px;
            font-family: 'Segoe UI', inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6366f1;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        }

        .submit-btn {
            background: #22c55e;
            color: white;
            padding: 14px 36px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.25s ease;
            align-self: flex-start;
            position: relative;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(20, 184, 166, 0.18);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            background: #16a34a;
            box-shadow: 0 18px 34px rgba(20, 184, 166, 0.24);
        }

        .submit-btn:hover:before {
            left: 100%;
        }

        .no-products {
            text-align: center;
            padding: 60px 40px;
            color: #95a5a6;
        }

        .no-products h3 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            padding: 30px 20px;
            margin-top: 50px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                padding: 25px;
            }

            .header h1 {
                font-size: 24px;
            }

            .user-info {
                text-align: center;
                margin-top: 20px;
            }

            .logout-btn {
                margin-left: 0;
                margin-top: 8px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }

            .contact-form {
                max-width: 100%;
            }

            .products-section {
                padding: 20px;
            }

            .welcome-section {
                padding: 20px;
            }

            .contact-section {
                padding: 25px;
            }

            .nav-links {
                flex-direction: column;
                gap: 10px;
            }

            .nav-link {
                width: 100%;
                text-align: center;
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
                <a href="<?php echo $baseUrl; ?>/profile" class="logout-btn" style="background: #2196F3; margin-right: 10px;">Cài Đặt Tài Khoản</a>
                <a href="<?php echo $baseUrl; ?>/logout" class="logout-btn">Đăng Xuất</a>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="nav-links">
            <a href="#san-pham" class="nav-link">📦 Xem Sản Phẩm</a>
            <a href="#lien-he" class="nav-link">📞 Liên Hệ Admin</a>
            <a href="<?php echo $baseUrl; ?>/profile" class="nav-link">👤 Hồ Sơ Cá Nhân</a>
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
                                <?php 
                                    $imgSrc = '';
                                    if (!empty($product['image'])) {
                                        $imgSrc = $baseUrl . htmlspecialchars($product['image']);
                                    } else {
                                        // Use placeholder image
                                        $productName = urlencode($product['name'] ?? 'Product');
                                        $imgSrc = 'https://via.placeholder.com/250x200?text=' . $productName;
                                    }
                                ?>
                                <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/250x200?text=<?php echo urlencode($product['name'] ?? 'Product'); ?>'">
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
                                <div class="product-actions">
                                    <a href="<?php echo $baseUrl; ?>/shop/<?php echo $product['id']; ?>" class="detail-btn">🔎 Xem Chi Tiết</a>
                                    <button class="contact-btn" onclick="document.location.href='#lien-he'">💬 Liên Hệ Để Mua</button>
                                </div>
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
