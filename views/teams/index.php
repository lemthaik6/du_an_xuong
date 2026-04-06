<div style="display: flex; gap: 20px;">
    <?php if ($isAdmin): ?>
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
    <?php endif; ?>
    
    <div class="main-content" style="<?php echo !$isAdmin ? 'max-width: 1000px; margin: 0 auto;' : ''; ?>">
        <div class="card" style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div>
                    <h2 style="margin: 0;">👨‍💼 Danh Sách Đội Nhóm</h2>
                    <p style="color: #666; margin: 5px 0;"><?php echo $isAdmin ? 'Quản lý các đội nhóm của dự án' : 'Các đội nhóm có sẵn'; ?></p>
                </div>
                <?php if ($isAdmin): ?>
                <a href="<?php echo $baseUrl; ?>/teams/create" class="btn btn-success" style="padding: 12px 20px;">+ Tạo Đội Nhóm</a>
                <?php else: ?>
                <a href="<?php echo $baseUrl; ?>/dashboard" class="btn btn-primary">← Quay Lại Dashboard</a>
                <?php endif; ?>
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
                            <?php if ($isAdmin): ?>
                            <th style="text-align: center;">Hành Động</th>
                            <?php else: ?>
                            <th>Tham Gia</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teams as $team): ?>
                            <tr>
                                <td>
                                    <strong style="font-size: 15px;">👥 <?php echo htmlspecialchars($team['name']); ?></strong>
                                    <?php if (!empty($team['description'])): ?>
                                        <br><small style="color: #999;">
                                            <?php echo htmlspecialchars(substr($team['description'], 0, 60)); ?>
                                            <?php echo strlen($team['description']) > 60 ? '...' : ''; ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="background: #e8f4f8; padding: 4px 8px; border-radius: 4px; font-size: 13px;">
                                        <?php echo htmlspecialchars($team['leader_name'] ?? 'Chưa gán'); ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="background: #ecf0f1; padding: 6px 10px; border-radius: 4px; text-align: center; font-weight: bold; display: inline-block;">
                                        📊 <?php echo $team['member_count'] ?? 0; ?> thành viên
                                    </div>
                                </td>
                                <td>
                                    <?php if ($team['status'] == 'active'): ?>
                                        <span style="background: #27ae60; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold;">
                                            ✓ Hoạt động
                                        </span>
                                    <?php else: ?>
                                        <span style="background: #95a5a6; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold;">
                                            ✗ Vô hiệu
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($isAdmin): ?>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 5px; justify-content: center;">
                                        <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">👁️ Xem</a>
                                        <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/edit" class="btn btn-warning" style="font-size: 12px; padding: 6px 12px;">✏️ Sửa</a>
                                        <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/delete" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px;" onclick="return confirm('Xóa đội nhóm này? Hành động này không thể hoàn tác.')">🗑️ Xóa</a>
                                    </div>
                                </td>
                                <?php else: ?>
                                <td>
                                    <?php if ($team['is_member'] ?? false): ?>
                                        <span style="background: #27ae60; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold;">
                                            ✓ Đã tham gia
                                        </span>
                                    <?php else: ?>
                                        <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem chi tiết</a>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card" style="background: #f8f9fa; text-align: center; padding: 40px;">
                <h3 style="color: #666;">Chưa có đội nhóm nào</h3>
                <p style="color: #999;">Tạo đội nhóm đầu tiên để bắt đầu quản lý dự án</p>
                <?php if ($isAdmin): ?>
                <a href="<?php echo $baseUrl; ?>/teams/create" class="btn btn-success" style="padding: 12px 20px; display: inline-block; margin-top: 10px;">+ Tạo Đội Nhóm Đầu Tiên</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
