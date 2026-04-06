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
    
    <div class="main-content" style="flex: 1;">
        <!-- Header Card -->
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 20px; padding: 30px;">
            <h2 style="margin: 0 0 10px 0; font-size: 28px;">📧 Liên Hệ Với Chúng Tôi</h2>
            <p style="margin: 0; opacity: 0.9;">Gửi tin nhắn cho chúng tôi - chúng tôi sẽ trả lời sớm nhất có thể</p>
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

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
            <!-- Contact Form -->
            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 20px;">✉️ Gửi Tin Nhắn</h3>
                <form method="POST" action="<?php echo $baseUrl; ?>/contact">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                            👤 Họ và Tên <span style="color: #e74c3c;">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            value="<?php echo htmlspecialchars($_POST['name'] ?? $_SESSION['full_name'] ?? ''); ?>"
                            placeholder="Nhập họ và tên"
                            style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box; font-size: 14px;"
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
                            placeholder="nhập email"
                            style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box; font-size: 14px;"
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
                            style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box; font-size: 14px;"
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
                            rows="5"
                            style="width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box; font-size: 14px; font-family: Arial, sans-serif; resize: vertical;"
                            required
                        ><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" class="btn" style="background: #27ae60; color: white; padding: 12px 24px; border-radius: 6px; border: none; font-weight: 500; cursor: pointer; flex: 1;">✓ Gửi Tin Nhắn</button>
                        <a href="<?php echo $baseUrl; ?>/dashboard" class="btn" style="background: #95a5a6; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500; text-align: center;">Hủy</a>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div>
                <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; margin-bottom: 16px; padding: 20px;">
                    <h4 style="margin-top: 0; margin-bottom: 16px;">📞 Liên Hệ Chúng Tôi</h4>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <p style="font-size: 12px; text-transform: uppercase; opacity: 0.9; margin: 0 0 6px 0; letter-spacing: 0.5px;">📧 Email</p>
                            <a href="mailto:support@duanxuong.com" style="color: white; text-decoration: none; font-weight: 500;">support@du​an​xuong.com</a>
                        </div>
                        <div>
                            <p style="font-size: 12px; text-transform: uppercase; opacity: 0.9; margin: 0 0 6px 0; letter-spacing: 0.5px;">📱 Điện Thoại</p>
                            <a href="tel:+84123456789" style="color: white; text-decoration: none; font-weight: 500;">+84 (0) 123 456 789</a>
                        </div>
                    </div>
                </div>

                <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px;">
                    <h4 style="margin-top: 0; margin-bottom: 16px;">📍 Địa Chỉ & Giờ Làm</h4>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <p style="font-size: 12px; text-transform: uppercase; opacity: 0.9; margin: 0 0 6px 0; letter-spacing: 0.5px;">📍 Địa Chỉ</p>
                            <p style="margin: 0; font-weight: 500;">123 Đường ABC, Quận XYZ, TP HCM</p>
                        </div>
                        <div>
                            <p style="font-size: 12px; text-transform: uppercase; opacity: 0.9; margin: 0 0 6px 0; letter-spacing: 0.5px;">⏰ Giờ Làm Việc</p>
                            <p style="margin: 0; font-weight: 500;">Thứ 2-6: 8:00-17:00<br>Thứ 7: 8:00-12:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
