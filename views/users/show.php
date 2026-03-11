<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/users">👥 Quản lý Người dùng</a>
        <a href="<?php echo $baseUrl; ?>/categories">📑 Quản lý Danh mục</a>
        <a href="<?php echo $baseUrl; ?>/projects">📌 Quản lý Dự án</a>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Quản lý Tác vụ</a>
        <a href="<?php echo $baseUrl; ?>/teams">👨‍💼 Quản lý Đội nhóm</a>
        <a href="<?php echo $baseUrl; ?>/profile">⚙️ Hồ sơ của tôi</a>
    </div>
    
    <div class="main-content">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;"><?php echo htmlspecialchars($user['full_name']); ?></h2>
                <div style="display: flex; gap: 10px;">
                    <a href="<?php echo $baseUrl; ?>/users/<?php echo $user['id']; ?>/edit" class="btn btn-warning">Sửa</a>
                    <a href="<?php echo $baseUrl; ?>/users" class="btn btn-primary">← Quay Lại</a>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <p><strong>Tên Đăng Nhập:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Số Điện Thoại:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?></p>
                </div>
                <div>
                    <p><strong>Vai Trò:</strong> 
                        <span style="background: <?php echo $user['role'] == 'admin' ? '#e74c3c' : '#3498db'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                            <?php echo $user['role'] == 'admin' ? 'Admin' : 'Người dùng'; ?>
                        </span>
                    </p>
                    <p><strong>Trạng Thái:</strong> 
                        <span style="background: <?php echo $user['status'] == 'active' ? '#27ae60' : '#95a5a6'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                            <?php echo $user['status'] == 'active' ? 'Hoạt động' : 'Vô hiệu'; ?>
                        </span>
                    </p>
                    <p><strong>Ngày Tham Gia:</strong> <?php echo date('d/m/Y', strtotime($user['created_at'] ?? 'now')); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
