<div style="max-width: 500px; margin: 30px auto;">
    <div class="card">
        <h2>Hồ Sơ Cá Nhân</h2>
        
        <div style="margin-bottom: 20px;">
            <p><strong>Tên Đăng Nhập:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Họ và Tên:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
            <p><strong>Số Điện Thoại:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?></p>
            <p><strong>Vai Trò:</strong> 
                <span style="background: <?php echo $user['role'] == 'admin' ? '#e74c3c' : '#3498db'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                    <?php echo $user['role'] == 'admin' ? 'Admin' : 'Người dùng'; ?>
                </span>
            </p>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <a href="<?php echo $baseUrl; ?>/profile/edit" class="btn btn-primary">Chỉnh Sửa Hồ Sơ</a>
            <a href="<?php echo $baseUrl; ?>/profile/change-password" class="btn btn-warning">Đổi Mật Khẩu</a>
        </div>
    </div>
</div>
