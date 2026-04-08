<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/users">👥 Quản lý Người dùng</a>
        <a href="<?php echo $baseUrl; ?>/categories">📑 Quản lý Danh mục</a>
        <a href="<?php echo $baseUrl; ?>/products">📦 Quản lý Sản phẩm</a>
        <a href="<?php echo $baseUrl; ?>/projects">📌 Quản lý Dự án</a>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Quản lý Tác vụ</a>
        <a href="<?php echo $baseUrl; ?>/teams">👨‍💼 Quản lý Đội nhóm</a>
        <a href="<?php echo $baseUrl; ?>/profile">⚙️ Hồ sơ của tôi</a>
    </div>
    
    <div class="main-content">
        <div class="card" style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Danh Sách Danh Mục</h2>
                <a href="<?php echo $baseUrl; ?>/categories/create" class="btn btn-success">+ Tạo Danh Mục</a>
            </div>
        </div>
        
        <?php if (is_array($categories) && count($categories) > 0): ?>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Tên Danh Mục</th>
                            <th>Mô Tả</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($category['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars(substr($category['description'] ?? '', 0, 50)); ?></td>
                                <td>
                                    <span style="background: <?php echo $category['status'] == 'active' ? '#27ae60' : '#95a5a6'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                                        <?php echo $category['status'] == 'active' ? 'Hoạt động' : 'Vô hiệu'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/categories/<?php echo $category['id']; ?>/edit" class="btn btn-warning" style="font-size: 12px; padding: 6px 12px;">Sửa</a>
                                    <a href="<?php echo $baseUrl; ?>/categories/<?php echo $category['id']; ?>/delete" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px; margin-top: 4px;" onclick="return confirm('Bạn có chắc chắn?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card">
                <div style="padding: 40px; text-align: center;">
                    <p style="font-size: 18px; color: #7f8c8d; margin-bottom: 20px;">📭 Không có danh mục nào</p>
                    <a href="<?php echo $baseUrl; ?>/categories/create" class="btn btn-success">+ Tạo danh mục đầu tiên</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
