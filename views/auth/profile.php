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
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="margin: 0 0 10px 0; font-size: 28px;">⚙️ Hồ Sơ Cá Nhân</h2>
                    <p style="margin: 0; opacity: 0.9;">Quản lý thông tin tài khoản của bạn</p>
                </div>
                <?php if ($user['role'] == 'admin'): ?>
                    <span style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 14px;">
                        👑 Administrator
                    </span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Profile Info Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 20px;">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea;">
                <p style="color: #999; font-size: 12px; text-transform: uppercase; margin: 0 0 10px 0; letter-spacing: 0.5px;">👤 Tên Đăng Nhập</p>
                <p style="font-size: 18px; font-weight: bold; margin: 0; color: #2c3e50;"><?php echo htmlspecialchars($user['username']); ?></p>
            </div>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #f093fb;">
                <p style="color: #999; font-size: 12px; text-transform: uppercase; margin: 0 0 10px 0; letter-spacing: 0.5px;">📧 Email</p>
                <p style="font-size: 18px; font-weight: bold; margin: 0; color: #2c3e50;"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #4facfe;">
                <p style="color: #999; font-size: 12px; text-transform: uppercase; margin: 0 0 10px 0; letter-spacing: 0.5px;">👤 Họ và Tên</p>
                <p style="font-size: 18px; font-weight: bold; margin: 0; color: #2c3e50;"><?php echo htmlspecialchars($user['full_name']); ?></p>
            </div>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #fa709a;">
                <p style="color: #999; font-size: 12px; text-transform: uppercase; margin: 0 0 10px 0; letter-spacing: 0.5px;">📱 Số Điện Thoại</p>
                <p style="font-size: 18px; font-weight: bold; margin: 0; color: #2c3e50;"><?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?></p>
            </div>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #fee140;">
                <p style="color: #999; font-size: 12px; text-transform: uppercase; margin: 0 0 10px 0; letter-spacing: 0.5px;">🎭 Vai Trò</p>
                <p style="font-size: 18px; font-weight: bold; margin: 0; color: #2c3e50;"><?php echo $user['role'] == 'admin' ? '👑 Quản trị viên' : '👤 Người dùng'; ?></p>
            </div>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #27ae60;">
                <p style="color: #999; font-size: 12px; text-transform: uppercase; margin: 0 0 10px 0; letter-spacing: 0.5px;">✓ Trạng Thái</p>
                <p style="font-size: 18px; font-weight: bold; margin: 0; color: #2c3e50;">
                    <span style="background: <?php echo $user['status'] == 'active' ? '#27ae60' : '#e74c3c'; ?>; color: white; padding: 6px 12px; border-radius: 4px;">
                        <?php echo $user['status'] == 'active' ? '✓ Hoạt động' : '✗ Bị khóa'; ?>
                    </span>
                </p>
            </div>
        </div>
        
        <?php if ($user['role'] == 'admin'): ?>
            <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; margin-bottom: 20px; padding: 20px;">
                <h3 style="margin-top: 0; font-size: 18px;">👑 Quyền Quản Trị Viên</h3>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                    <div style="padding: 12px; background: rgba(255,255,255,0.1); border-radius: 6px;">✓ Quản lý người dùng</div>
                    <div style="padding: 12px; background: rgba(255,255,255,0.1); border-radius: 6px;">✓ Quản lý dự án</div>
                    <div style="padding: 12px; background: rgba(255,255,255,0.1); border-radius: 6px;">✓ Quản lý tác vụ</div>
                    <div style="padding: 12px; background: rgba(255,255,255,0.1); border-radius: 6px;">✓ Quản lý đội nhóm</div>
                </div>
            </div>
        <?php endif; ?>
        
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="<?php echo $baseUrl; ?>/profile/edit" class="btn" style="background: #3498db; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500;">✏️ Chỉnh Sửa Hồ Sơ</a>
            <a href="<?php echo $baseUrl; ?>/profile/change-password" class="btn" style="background: #f39c12; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500;">🔒 Đổi Mật Khẩu</a>
            <a href="<?php echo $baseUrl; ?>/dashboard" class="btn" style="background: #95a5a6; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500;">← Quay Lại</a>
        </div>
    </div>
</div>
