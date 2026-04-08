<div style="display: flex; gap: 20px;">
    <?php if ($isAdmin): ?>
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
    <?php else: ?>
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/projects">📌 Dự án của tôi</a>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Tác vụ của tôi</a>
        <a href="<?php echo $baseUrl; ?>/teams">👨‍💼 Đội nhóm</a>
        <a href="<?php echo $baseUrl; ?>/contact">📧 Liên hệ</a>
        <a href="<?php echo $baseUrl; ?>/profile">⚙️ Hồ sơ của tôi</a>
        <a href="<?php echo $baseUrl; ?>/logout">🚪 Đăng xuất</a>
    </div>
    <?php endif; ?>
    
    <div class="main-content" style="flex: 1;">
        <!-- Header Card -->
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 20px; padding: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="margin: 0 0 10px 0; font-size: 28px;">👨‍💼 <?php echo $isAdmin ? 'Quản Lý Đội Nhóm' : 'Các Đội Nhóm'; ?></h2>
                    <p style="margin: 0; opacity: 0.9;"><?php echo $isAdmin ? 'Quản lý các đội nhóm của dự án' : 'Các đội nhóm có sẵn'; ?></p>
                </div>
                <?php if ($isAdmin): ?>
                <a href="<?php echo $baseUrl; ?>/teams/create" style="background: white; color: #667eea; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500;">+ Tạo Đội Nhóm</a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (!empty($teams)): ?>
            <?php if ($isAdmin): ?>
                <!-- ADMIN TABLE VIEW -->
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>Tên Đội Nhóm</th>
                                <th>Lãnh Đạo</th>
                                <th>Số Thành Viên</th>
                                <th>Trạng Thái</th>
                                <th style="text-align: center;">Hành Động</th>
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
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 5px; justify-content: center;">
                                            <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>" style="background: #3498db; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500;">Xem</a>
                                            <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/edit" style="background: #f39c12; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500;">Sửa</a>
                                            <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/delete" style="background: #e74c3c; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500;" onclick="return confirm('Xóa đội nhóm này? Hành động này không thể hoàn tác.')">Xóa</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- USER CARD VIEW -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                    <?php foreach ($teams as $team): ?>
                        <div class="card" style="border-left: 4px solid #667eea;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                <h3 style="margin: 0; color: #2c3e50; flex: 1;">👥 <?php echo htmlspecialchars($team['name']); ?></h3>
                                <span style="background: <?php echo $team['status'] == 'active' ? '#27ae60' : '#95a5a6'; ?>; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; white-space: nowrap;">
                                    <?php echo $team['status'] == 'active' ? '✓ Hoạt động' : '✗ Vô hiệu'; ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($team['description'])): ?>
                                <p style="color: #666; margin: 8px 0; font-size: 14px;">
                                    <?php echo htmlspecialchars($team['description']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <p style="color: #666; margin: 8px 0; font-size: 14px;">
                                <strong>👨‍💼 Lãnh Đạo:</strong> <?php echo htmlspecialchars($team['leader_name'] ?? 'Chưa gán'); ?>
                            </p>
                            
                            <p style="color: #666; margin: 8px 0; font-size: 14px;">
                                <strong>👥 Thành Viên:</strong>
                                <span style="background: #ecf0f1; padding: 4px 8px; border-radius: 4px; display: inline-block;">
                                    <?php echo $team['member_count'] ?? 0; ?> người
                                </span>
                            </p>
                            
                            <div style="display: flex; gap: 8px; margin-top: 16px;">
                                <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>" style="flex: 1; background: #3498db; color: white; text-align: center; padding: 10px; border-radius: 6px; text-decoration: none; font-weight: 500;">Xem Chi Tiết</a>
                                <?php if ($team['is_member'] ?? false): ?>
                                    <span style="background: #27ae60; color: white; padding: 10px 16px; border-radius: 6px; font-weight: 500;">✓ Đã tham gia</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="card" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); text-align: center; padding: 60px 40px;">
                <p style="font-size: 48px; margin: 0 0 16px 0;">👭</p>
                <h3 style="color: #2c3e50; margin: 0 0 16px 0;">Chưa có đội nhóm nào</h3>
                <p style="color: #999; margin: 0 0 16px 0;">Tạo đội nhóm đầu tiên để bắt đầu quản lý dự án</p>
                <?php if ($isAdmin): ?>
                <a href="<?php echo $baseUrl; ?>/teams/create" style="background: #3498db; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-block; margin-top: 10px;">+ Tạo Đội Nhóm Đầu Tiên</a>
                <?php else: ?>
                <a href="<?php echo $baseUrl; ?>/dashboard" style="background: #3498db; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-block; margin-top: 10px;">← Quay Lại Dashboard</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
