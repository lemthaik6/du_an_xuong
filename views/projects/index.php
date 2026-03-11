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
        <div class="card" style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Danh Sách Dự Án</h2>
                <a href="<?php echo $baseUrl; ?>/projects/create" class="btn btn-success">+ Tạo Dự Án</a>
            </div>
        </div>
        
        <?php if (!empty($projects)): ?>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Tên Dự Án</th>
                            <th>Danh Mục</th>
                            <th>Người Theo Dõi</th>
                            <th>Trạng Thái</th>
                            <th>Tiến Độ</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($project['name']); ?></td>
                                <td><?php echo htmlspecialchars($project['category_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($project['assigned_name'] ?? 'Chưa gán'); ?></td>
                                <td>
                                    <span style="background: <?php echo $project['status'] == 'planning' ? '#3498db' : ($project['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                                        <?php 
                                            $statusMap = [
                                                'planning' => 'Lên kế hoạch',
                                                'in_progress' => 'Đang tiến hành',
                                                'completed' => 'Hoàn thành',
                                                'cancelled' => 'Hủy'
                                            ];
                                            echo $statusMap[$project['status']] ?? $project['status'];
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 20px;">
                                        <div style="background: #3498db; height: 100%; width: <?php echo $project['progress']; ?>%;"></div>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem</a>
                                    <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>/edit" class="btn btn-warning" style="font-size: 12px; padding: 6px 12px;">Sửa</a>
                                    <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>/delete" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px; margin-top: 4px;" onclick="return confirm('Bạn có chắc chắn?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card">
                <p>Không có dự án nào. <a href="/du_an_xuong/public/projects/create">Tạo dự án đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
