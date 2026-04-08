<?php if ($isAdmin): ?>
<!-- ADMIN VIEW -->
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
    
    <div class="main-content" style="flex: 1;">
        <!-- Header Card -->
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 20px; padding: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="margin: 0 0 10px 0; font-size: 28px;">📌 Quản Lý Dự Án</h2>
                    <p style="margin: 0; opacity: 0.9;">Quản lý tất cả dự án của hệ thống</p>
                </div>
                <a href="<?php echo $baseUrl; ?>/projects/create" style="background: white; color: #667eea; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500;">+ Tạo Dự Án</a>
            </div>
        </div>

        <!-- Search & Filter Form -->
        <div class="card" style="margin-bottom: 20px; background: #f8f9fa; padding: 20px;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">🔍 Tìm kiếm</label>
                    <input type="text" name="search" placeholder="Tên hoặc mô tả..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                </div>
                
                <?php if (!empty($categories)): ?>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📁 Danh Mục</label>
                    <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                        <option value="">-- Tất cả --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($filters['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📊 Trạng Thái</label>
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                        <option value="">-- Tất cả --</option>
                        <option value="planning" <?php echo ($filters['status'] ?? '') == 'planning' ? 'selected' : ''; ?>>Lên kế hoạch</option>
                        <option value="in_progress" <?php echo ($filters['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>Đang tiến hành</option>
                        <option value="completed" <?php echo ($filters['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                        <option value="cancelled" <?php echo ($filters['status'] ?? '') == 'cancelled' ? 'selected' : ''; ?>>Hủy</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 8px; align-items: flex-end;">
                    <button type="submit" style="flex: 1; background: #3498db; color: white; padding: 10px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer;">🔎 Tìm Kiếm</button>
                    <a href="<?php echo $baseUrl; ?>/projects" style="background: #95a5a6; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 500;">Đặt Lại</a>
                </div>
            </form>
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
                                <td><strong><?php echo htmlspecialchars($project['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($project['category_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($project['assigned_name'] ?? 'Chưa gán'); ?></td>
                                <td>
                                    <span style="background: <?php echo $project['status'] == 'planning' ? '#3498db' : ($project['status'] == 'in_progress' ? '#f39c12' : ($project['status'] == 'completed' ? '#27ae60' : '#e74c3c')); ?>; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px;">
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
                                        <div style="background: linear-gradient(90deg, #3498db, #2980b9); height: 100%; width: <?php echo $project['progress']; ?>%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 10px;">
                                            <?php echo $project['progress']; ?>%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>" style="background: #3498db; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500;">Xem</a>
                                    <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>/edit" style="background: #f39c12; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500; margin-left: 4px;">Sửa</a>
                                    <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>/delete" style="background: #e74c3c; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500; margin-left: 4px; margin-top: 4px;" onclick="return confirm('Bạn có chắc chắn?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card" style="text-align: center; padding: 40px;">
                <p style="color: #999;">📭 Không có dự án nào. <a href="<?php echo $baseUrl; ?>/projects/create" style="color: #3498db;">Tạo dự án đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php else: ?>
<!-- USER VIEW -->
<div style="display: flex; gap: 20px;">
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
    
    <div class="main-content" style="flex: 1;">
        <!-- Header Card -->
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 20px; padding: 30px;">
            <h2 style="margin: 0 0 10px 0; font-size: 28px;">📌 Dự Án Của Tôi</h2>
            <p style="margin: 0; opacity: 0.9;">Các dự án được gán cho bạn</p>
        </div>

        <!-- Search Form -->
        <div class="card" style="margin-bottom: 20px; background: #f8f9fa; padding: 20px;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">🔍 Tìm kiếm</label>
                    <input type="text" name="search" placeholder="Tên hoặc mô tả..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                </div>
                
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📊 Trạng Thái</label>
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                        <option value="">-- Tất cả --</option>
                        <option value="planning" <?php echo ($filters['status'] ?? '') == 'planning' ? 'selected' : ''; ?>>Lên kế hoạch</option>
                        <option value="in_progress" <?php echo ($filters['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>Đang tiến hành</option>
                        <option value="completed" <?php echo ($filters['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 8px; align-items: flex-end;">
                    <button type="submit" style="flex: 1; background: #3498db; color: white; padding: 10px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer;">🔎 Tìm Kiếm</button>
                    <a href="<?php echo $baseUrl; ?>/projects" style="background: #95a5a6; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 500;">Đặt Lại</a>
                </div>
            </form>
        </div>
        
        <?php if (!empty($projects)): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                <?php foreach ($projects as $project): ?>
                    <div class="card" style="border-left: 4px solid <?php echo $project['status'] == 'planning' ? '#3498db' : ($project['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                            <h3 style="margin: 0; color: #2c3e50; flex: 1;">
                                <?php echo htmlspecialchars($project['name']); ?>
                            </h3>
                            <span style="background: <?php echo $project['status'] == 'planning' ? '#3498db' : ($project['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; white-space: nowrap;">
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
                            <strong>📁 Danh Mục:</strong> <?php echo htmlspecialchars($project['category_name'] ?? 'N/A'); ?>
                        </p>
                        
                        <?php if ($project['start_date']): ?>
                            <p style="color: #666; margin: 8px 0; font-size: 14px;">
                                <strong>📅 Thời gian:</strong> <?php echo date('d/m/Y', strtotime($project['start_date'])); ?> 
                                <?php if ($project['end_date']): ?> → <?php echo date('d/m/Y', strtotime($project['end_date'])); ?> <?php endif; ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($project['budget']): ?>
                            <p style="color: #666; margin: 8px 0; font-size: 14px;">
                                <strong>💰 Ngân sách:</strong> <?php echo number_format($project['budget'], 0, ',', '.'); ?> VND
                            </p>
                        <?php endif; ?>
                        
                        <div style="margin: 16px 0;">
                            <p style="color: #666; margin: 4px 0 8px 0; font-size: 12px; font-weight: bold;">Tiến độ: <span style="color: #3498db;"><?php echo $project['progress']; ?>%</span></p>
                            <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 24px;">
                                <div style="background: linear-gradient(90deg, #3498db, #2980b9); height: 100%; width: <?php echo $project['progress']; ?>%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">
                                    <?php if ($project['progress'] > 15): echo $project['progress'] . '%'; endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 8px; margin-top: 16px;">
                            <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>" style="flex: 1; background: #3498db; color: white; text-align: center; padding: 10px; border-radius: 6px; text-decoration: none; font-weight: 500;">Xem Chi Tiết</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card" style="text-align: center; padding: 60px 40px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                <p style="font-size: 48px; margin: 0 0 16px 0;">📭</p>
                <p style="font-size: 18px; color: #2c3e50; margin: 0 0 16px 0; font-weight: bold;">Chưa có dự án nào</p>
                <p style="color: #999; margin: 0 0 16px 0;">Bạn hiện chưa được gán dự án nào. Hãy liên hệ với quản trị viên để được gán.</p>
                <a href="<?php echo $baseUrl; ?>/dashboard" style="background: #3498db; color: white; padding: 10px 24px; border-radius: 6px; text-decoration: none; font-weight: 500;">← Quay Lại Dashboard</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
