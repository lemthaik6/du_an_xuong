<?php if ($isAdmin): ?>
<!-- ADMIN VIEW -->
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
                <p>Không có dự án nào. <a href="<?php echo $baseUrl; ?>/projects/create">Tạo dự án đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php else: ?>
<!-- USER VIEW -->
<div style="max-width: 1000px; margin: 0 auto;">
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">🚀 Dự Án Của Tôi</h2>
            <a href="<?php echo $baseUrl; ?>/dashboard" class="btn btn-primary">← Quay Lại Dashboard</a>
        </div>
    </div>
    
    <?php if (!empty($projects)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
            <?php foreach ($projects as $project): ?>
                <div class="card" style="cursor: pointer; transition: transform 0.2s; hover: transform scale(1.02);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                        <h3 style="margin: 0; color: #2c3e50; flex: 1;">
                            <?php echo htmlspecialchars($project['name']); ?>
                        </h3>
                        <span style="background: <?php echo $project['status'] == 'planning' ? '#3498db' : ($project['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap;">
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
                    </div>
                    
                    <p style="color: #666; margin: 8px 0; font-size: 14px;">
                        <strong>Danh Mục:</strong> <?php echo htmlspecialchars($project['category_name'] ?? 'N/A'); ?>
                    </p>
                    
                    <?php if ($project['start_date']): ?>
                        <p style="color: #666; margin: 8px 0; font-size: 14px;">
                            <strong>Thời gian:</strong> <?php echo date('d/m/Y', strtotime($project['start_date'])); ?> 
                            <?php if ($project['end_date']): ?> - <?php echo date('d/m/Y', strtotime($project['end_date'])); ?> <?php endif; ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if ($project['budget']): ?>
                        <p style="color: #666; margin: 8px 0; font-size: 14px;">
                            <strong>Ngân sách:</strong> <?php echo number_format($project['budget'], 0, ',', '.'); ?> VND
                        </p>
                    <?php endif; ?>
                    
                    <div style="margin: 12px 0;">
                        <p style="color: #666; margin: 4px 0; font-size: 12px;">Tiến độ:</p>
                        <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 24px;">
                            <div style="background: linear-gradient(90deg, #3498db, #2980b9); height: 100%; width: <?php echo $project['progress']; ?>%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">
                                <?php echo $project['progress']; ?>%
                            </div>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 8px; margin-top: 16px;">
                        <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>" class="btn btn-primary" style="flex: 1; text-align: center; padding: 8px;">Xem Chi Tiết</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 40px;">
            <p style="font-size: 16px; color: #666; margin-bottom: 20px;">
                📭 Bạn hiện chưa được gán dự án nào.
            </p>
            <p style="color: #999; margin-bottom: 20px;">
                Hãy liên hệ với quản trị viên để được gán vào các dự án.
            </p>
            <a href="<?php echo $baseUrl; ?>/dashboard" class="btn btn-primary">← Quay Lại Dashboard</a>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
        
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
                <p>Không có dự án nào. <a href="<?php echo $baseUrl; ?>/projects/create">Tạo dự án đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
