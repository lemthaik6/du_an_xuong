<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/projects">📌 Dự án của tôi</a>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Tác vụ của tôi</a>
        <a href="<?php echo $baseUrl; ?>/teams">👨‍💼 Đội nhóm</a>
        <a href="<?php echo $baseUrl; ?>/contact">📧 Liên hệ</a>
        <a href="<?php echo $baseUrl; ?>/profile">⚙️ Hồ sơ của tôi</a>
    </div>
    
    <div class="main-content">
        <div class="card" style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="margin: 0;">📧 Liên Hệ Với Chúng Tôi</h2>
                    <p style="color: #666; margin: 5px 0;">Gửi tin nhắn cho chúng tôi</p>
                </div>
                <a href="<?php echo $baseUrl; ?>/dashboard" class="btn btn-primary">← Quay Lại Dashboard</a>
            </div>
        </div>

        <?php if ($flash = $this->getFlash('success')): ?>
            <div class="card" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                <strong>✓ Thành công!</strong> <?php echo htmlspecialchars($flash); ?>
            </div>
        <?php endif; ?>

        <?php if ($flash = $this->getFlash('error')): ?>
            <div class="card" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                <strong>✗ Lỗi!</strong> <?php echo htmlspecialchars($flash); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="POST" action="<?php echo $baseUrl; ?>/contact" style="max-width: 600px;">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                        👤 Họ và Tên <span style="color: #e74c3c;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="<?php echo htmlspecialchars($_POST['name'] ?? $_SESSION['full_name'] ?? ''); ?>"
                        placeholder="Nhập họ và tên"
                        style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; font-size: 14px;"
                        required
                    />
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                        📧 Email <span style="color: #e74c3c;">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        placeholder="Nhập email"
                        style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; font-size: 14px;"
                        required
                    />
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                        💬 Chủ Đề <span style="color: #e74c3c;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="subject" 
                        value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>"
                        placeholder="Nhập chủ đề"
                        style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; font-size: 14px;"
                        required
                    />
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                        📝 Nội Dung <span style="color: #e74c3c;">*</span>
                    </label>
                    <textarea 
                        name="message" 
                        placeholder="Nhập nội dung tin nhắn"
                        rows="6"
                        style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; font-size: 14px; font-family: Arial, sans-serif;"
                        required
                    ><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success" style="padding: 12px 24px; flex: 1;">✓ Gửi Tin Nhắn</button>
                    <a href="<?php echo $baseUrl; ?>/dashboard" class="btn btn-secondary" style="padding: 12px 24px;">Hủy</a>
                </div>
            </form>
        </div>

        <div class="card" style="margin-top: 30px; background: #f8f9fa;">
            <h3 style="margin-top: 0;">📞 Thông Tin Liên Hệ</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <h4 style="color: #3498db; margin-top: 0;">Email</h4>
                    <p>
                        <a href="mailto:support@duanxuong.com" style="color: #3498db; text-decoration: none;">support@duanxuong.com</a>
                    </p>
                </div>
                <div>
                    <h4 style="color: #3498db; margin-top: 0;">Điện Thoại</h4>
                    <p>
                        <a href="tel:+84123456789" style="color: #3498db; text-decoration: none;">+84 (0) 123 456 789</a>
                    </p>
                </div>
                <div>
                    <h4 style="color: #3498db; margin-top: 0;">Địa Chỉ</h4>
                    <p>123 Đường ABC, Quận XYZ, TP Hồ Chí Minh</p>
                </div>
                <div>
                    <h4 style="color: #3498db; margin-top: 0;">Giờ Làm Việc</h4>
                    <p>Thứ Hai - Thứ Sáu: 8:00 - 17:00<br>Thứ Bảy: 8:00 - 12:00</p>
                </div>
            </div>
        </div>
    </div>
</div>
