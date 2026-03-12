<div style="max-width: 800px; margin: 30px auto;">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h2>Hồ Sơ Cá Nhân</h2>
                <p style="color: #666; margin: 10px 0;">Quản lý thông tin tài khoản của bạn</p>
            </div>
            <?php if ($user['role'] == 'admin'): ?>
                <span style="background: #e74c3c; color: white; padding: 8px 16px; border-radius: 4px; font-weight: bold;">
                    👑 Administrator
                </span>
            <?php endif; ?>
        </div>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <p style="color: #999; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Tên Đăng Nhập</p>
                    <p style="font-size: 16px; font-weight: bold;">
                        <?php echo htmlspecialchars($user['username']); ?>
                    </p>
                </div>
                
                <div>
                    <p style="color: #999; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Email</p>
                    <p style="font-size: 16px; font-weight: bold;">
                        <?php echo htmlspecialchars($user['email']); ?>
                    </p>
                </div>
                
                <div>
                    <p style="color: #999; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Họ và Tên</p>
                    <p style="font-size: 16px; font-weight: bold;">
                        <?php echo htmlspecialchars($user['full_name']); ?>
                    </p>
                </div>
                
                <div>
                    <p style="color: #999; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Số Điện Thoại</p>
                    <p style="font-size: 16px; font-weight: bold;">
                        <?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?>
                    </p>
                </div>
                
                <div>
                    <p style="color: #999; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Vai Trò</p>
                    <p style="font-size: 16px; font-weight: bold;">
                        <?php echo $user['role'] == 'admin' ? '👑 Quản trị viên' : '👤 Người dùng'; ?>
                    </p>
                </div>
                
                <div>
                    <p style="color: #999; font-size: 12px; text-transform: uppercase; margin-bottom: 5px;">Trạng Thái</p>
                    <p style="font-size: 16px; font-weight: bold;">
                        <span style="background: <?php echo $user['status'] == 'active' ? '#27ae60' : '#e74c3c'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                            <?php echo $user['status'] == 'active' ? '✓ Hoạt động' : '✗ Bị khóa'; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        
        <?php if ($user['role'] == 'admin'): ?>
            <div style="background: #ecf0f1; padding: 15px; border-radius: 4px; margin-bottom: 30px;">
                <h4 style="margin: 0 0 10px 0;">📊 Quyền Quản Trị Viên</h4>
                <ul style="margin: 0; padding-left: 20px; color: #555;">
                    <li>Quản lý người dùng hệ thống</li>
                    <li>Quản lý dự án và nhiệm vụ</li>
                    <li>Quản lý đội nhóm</li>
                    <li>Quản lý danh mục</li>
                </ul>
            </div>
        <?php endif; ?>
        
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="<?php echo $baseUrl; ?>/profile/edit" class="btn btn-primary" style="padding: 10px 20px;">✏️ Chỉnh Sửa Hồ Sơ</a>
            <a href="<?php echo $baseUrl; ?>/profile/change-password" class="btn btn-warning" style="padding: 10px 20px;">🔒 Đổi Mật Khẩu</a>
            <a href="<?php echo $baseUrl; ?>/dashboard" class="btn btn-secondary" style="padding: 10px 20px;">← Quay Lại Dashboard</a>
        </div>
    </div>
</div>
