<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/users">👥 Quản lý Người dùng</a>
    </div>
    
    <div class="main-content">
        <div class="card" style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Danh Sách Người Dùng</h2>
                <a href="<?php echo $baseUrl; ?>/users/create" class="btn btn-success">+ Tạo Người Dùng</a>
            </div>
        </div>
        
        <?php if (!empty($users)): ?>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Tên Đăng Nhập</th>
                            <th>Email</th>
                            <th>Họ và Tên</th>
                            <th>Số Điện Thoại</th>
                            <th>Vai Trò</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                                <td>
                                    <span style="background: <?php echo $user['role'] == 'admin' ? '#e74c3c' : '#3498db'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                                        <?php echo $user['role'] == 'admin' ? 'Admin' : 'Người dùng'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="background: <?php echo $user['status'] == 'active' ? '#27ae60' : '#95a5a6'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                                        <?php echo $user['status'] == 'active' ? 'Hoạt động' : 'Vô hiệu'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/users/<?php echo $user['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem</a>
                                    <a href="<?php echo $baseUrl; ?>/users/<?php echo $user['id']; ?>/edit" class="btn btn-warning" style="font-size: 12px; padding: 6px 12px;">Sửa</a>
                                    <a href="<?php echo $baseUrl; ?>/users/<?php echo $user['id']; ?>/delete" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px; margin-top: 4px;" onclick="return confirm('Bạn có chắc chắn?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card">
                <p>Không có người dùng nào. <a href="<?php echo $baseUrl; ?>/users/create">Tạo người dùng đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
