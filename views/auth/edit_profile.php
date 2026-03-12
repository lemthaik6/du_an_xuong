<div style="max-width: 600px; margin: 30px auto;">
    <div class="card">
        <h2>🖊️ Chỉnh Sửa Hồ Sơ Cá Nhân</h2>
        
        <?php if (isset($flash) && !empty($flash)): ?>
            <div style="background: <?php echo $flash['type'] == 'error' ? '#e74c3c' : '#27ae60'; ?>; 
                        color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/profile/edit">
            <div class="form-group">
                <label for="username">👤 Tên Đăng Nhập <span style="color: #999;">(không thể thay đổi)</span></label>
                <input type="text" id="username" name="username" disabled value="<?php echo htmlspecialchars($user['username']); ?>" 
                       style="background: #f0f0f0; cursor: not-allowed;">
            </div>
            
            <div class="form-group">
                <label for="email">📧 Email <span style="color: #999;">(không thể thay đổi)</span></label>
                <input type="email" id="email" name="email" disabled value="<?php echo htmlspecialchars($user['email']); ?>" 
                       style="background: #f0f0f0; cursor: not-allowed;">
            </div>
            
            <div class="form-group">
                <label for="full_name">👨‍💼 Họ và Tên <span style="color: red;">*</span></label>
                <input type="text" id="full_name" name="full_name" required 
                       value="<?php echo htmlspecialchars($user['full_name']); ?>"
                       placeholder="Nhập họ và tên">
                <small style="color: #999;">Tên đầy đủ sẽ hiển thị trên hệ thống</small>
            </div>
            
            <div class="form-group">
                <label for="phone">📱 Số Điện Thoại</label>
                <input type="tel" id="phone" name="phone" 
                       value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                       placeholder="Ví dụ: 0987654321">
                <small style="color: #999;">Tùy chọn - Để trống nếu không muốn cập nhật</small>
            </div>
            
            <div style="background: #f8f9fa; padding: 15px; border-radius: 4px; margin: 20px 0;">
                <h4 style="margin-top: 0;">ℹ️ Thông Tin Tài Khoản</h4>
                <p style="margin: 10px 0;">
                    <strong>Vai Trò:</strong> 
                    <span style="background: <?php echo $user['role'] == 'admin' ? '#e74c3c' : '#3498db'; ?>; 
                           color: white; padding: 4px 8px; border-radius: 4px;">
                        <?php echo $user['role'] == 'admin' ? '👑 Administrator' : '👤 Người Dùng'; ?>
                    </span>
                </p>
                <p style="margin: 10px 0;">
                    <strong>Trạng Thái:</strong> 
                    <span style="background: <?php echo $user['status'] == 'active' ? '#27ae60' : '#e74c3c'; ?>; 
                           color: white; padding: 4px 8px; border-radius: 4px;">
                        <?php echo $user['status'] == 'active' ? '✓ Hoạt động' : '✗ Bị khóa'; ?>
                    </span>
                </p>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success" style="padding: 12px 20px; font-weight: bold;">💾 Lưu Thay Đổi</button>
                <a href="<?php echo $baseUrl; ?>/profile" class="btn btn-primary" style="padding: 12px 20px;">← Quay Lại Hồ Sơ</a>
            </div>
        </form>
    </div>
</div>
