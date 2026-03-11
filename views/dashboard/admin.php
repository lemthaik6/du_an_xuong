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
            <h2>Dashboard Quản Trị</h2>
            <p>Chào mừng bạn đến với trang quản lý hệ thống Du An Xuong.</p>
        </div>
        
        <div class="stats">
            <div class="stat-card" style="border-left-color: #3498db;">
                <h3>Tổng Người Dùng</h3>
                <div class="value"><?php echo $stats['total_users'] ?? 0; ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #2ecc71;">
                <h3>Tổng Dự Án</h3>
                <div class="value"><?php echo $stats['total_projects'] ?? 0; ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #e74c3c;">
                <h3>Tổng Tác Vụ</h3>
                <div class="value"><?php echo $stats['total_tasks'] ?? 0; ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #f39c12;">
                <h3>Đội Nhóm</h3>
                <div class="value"><?php echo $stats['total_teams'] ?? 0; ?></div>
            </div>
        </div>
        
        <div class="card">
            <h2>Hoạt Động Gần Đây</h2>
            <?php if (!empty($activities)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Người Dùng</th>
                            <th>Hành Động</th>
                            <th>Thực Thể</th>
                            <th>Thời Gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($activities, 0, 10) as $activity): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($activity['username'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($activity['action']); ?></td>
                                <td><?php echo htmlspecialchars($activity['entity_type']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($activity['created_at'] ?? 'now')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Không có hoạt động nào.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
