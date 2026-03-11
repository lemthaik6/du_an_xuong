<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/categories">📑 Danh mục</a>
    </div>
    
    <div class="main-content">
        <div class="card" style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Danh Sách Danh Mục</h2>
                <a href="<?php echo $baseUrl; ?>/categories/create" class="btn btn-success">+ Tạo Danh Mục</a>
            </div>
        </div>
        
        <?php if (!empty($categories)): ?>
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
                <p>Không có danh mục nào. <a href="/du_an_xuong/public/categories/create">Tạo danh mục đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
