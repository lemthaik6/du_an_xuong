<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/teams">👨‍💼 Đội nhóm</a>
    </div>
    
    <div class="main-content">
        <div class="card" style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Danh Sách Đội Nhóm</h2>
                <a href="<?php echo $baseUrl; ?>/teams/create" class="btn btn-success">+ Tạo Đội Nhóm</a>
            </div>
        </div>
        
        <?php if (!empty($teams)): ?>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Tên Đội Nhóm</th>
                            <th>Lãnh Đạo</th>
                            <th>Số Thành Viên</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teams as $team): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($team['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($team['leader_name'] ?? 'N/A'); ?></td>
                                <td>
                                    <span style="background: #ecf0f1; padding: 4px 8px; border-radius: 4px;">
                                        <?php echo $team['member_count'] ?? 0; ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="background: <?php echo $team['status'] == 'active' ? '#27ae60' : '#95a5a6'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                                        <?php echo $team['status'] == 'active' ? 'Hoạt động' : 'Vô hiệu'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem</a>
                                    <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/edit" class="btn btn-warning" style="font-size: 12px; padding: 6px 12px;">Sửa</a>
                                    <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/delete" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px; margin-top: 4px;" onclick="return confirm('Bạn có chắc chắn?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card">
                <p>Không có đội nhóm nào. <a href="/du_an_xuong/public/teams/create">Tạo đội nhóm đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
