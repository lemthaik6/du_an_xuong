<div style="max-width: 600px; margin: 30px auto;">
    <div class="card">
        <h2>🔒 Đổi Mật Khẩu</h2>
        <p style="color: #666; margin-bottom: 20px;">Vui lòng nhập mật khẩu cũ của bạn và mật khẩu mới</p>
        
        <?php if (isset($flash) && !empty($flash)): ?>
            <div style="background: <?php echo $flash['type'] == 'error' ? '#e74c3c' : '#27ae60'; ?>; 
                        color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/profile/change-password">
            <div class="form-group">
                <label for="old_password">🔐 Mật Khẩu Cũ <span style="color: red;">*</span></label>
                <input type="password" id="old_password" name="old_password" required 
                       placeholder="Nhập mật khẩu hiện tại của bạn"
                       style="font-family: 'Arial', sans-serif;">
                <small style="color: #999;">Nhập mật khẩu bạn đang sử dụng để xác nhận danh tính</small>
            </div>
            
            <div style="background: #ecf0f1; padding: 15px; border-radius: 4px; margin: 20px 0;">
                <h4 style="margin: 0 0 15px 0;">📋 Yêu Cầu Mật Khẩu Mới</h4>
                <ul style="margin: 0; padding-left: 20px; color: #555; font-size: 13px;">
                    <li>Tối thiểu 6 ký tự</li>
                    <li>Nên kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                    <li>Không nên sử dụng mật khẩu đã dùng trước đó</li>
                </ul>
            </div>
            
            <div class="form-group">
                <label for="new_password">🔑 Mật Khẩu Mới <span style="color: red;">*</span></label>
                <input type="password" id="new_password" name="new_password" required minlength="6"
                       placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)"
                       style="font-family: 'Arial', sans-serif;">
                <small style="color: #999;">Phải khác với mật khẩu hiện tại</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">✓ Nhập Lại Mật Khẩu Mới <span style="color: red;">*</span></label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="6"
                       placeholder="Nhập lại mật khẩu mới"
                       style="font-family: 'Arial', sans-serif;">
                <small style="color: #999;">Phải trùng khớp với mật khẩu mới ở trên</small>
            </div>
            
            <div style="color: #999; padding: 10px; background: #f9f9f9; border-left: 3px solid #3498db; margin: 20px 0;">
                <strong>💡 Mẹo Bảo Mật:</strong> Hãy tạo mật khẩu mạnh mẽ và không chia sẻ với bất kỳ ai. 
                Nếu bạn cảm thấy tài khoản có vấn đề, vui lòng liên hệ quản trị viên.
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success" style="padding: 12px 20px; font-weight: bold;">💾 Đổi Mật Khẩu</button>
                <a href="<?php echo $baseUrl; ?>/profile" class="btn btn-primary" style="padding: 12px 20px;">← Quay Lại Hồ Sơ</a>
            </div>
        </form>
    </div>
</div>
