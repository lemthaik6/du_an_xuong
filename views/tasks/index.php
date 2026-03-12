<?php if ($isAdmin ?? false): ?>
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
                <h2 style="margin: 0;">Danh Sách Tác Vụ</h2>
                <a href="<?php echo $baseUrl; ?>/tasks/create" class="btn btn-success">+ Tạo Tác Vụ</a>
            </div>
        </div>

        <!-- Search & Filter Form -->
        <div class="card" style="margin-bottom: 20px; background: #f8f9fa;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">🔍 Tìm kiếm</label>
                    <input type="text" name="search" placeholder="Tiêu đề hoặc mô tả..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="width: 100%; padding: 8px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box;">
                </div>
                
                <?php if (!empty($projects)): ?>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📌 Dự Án</label>
                    <select name="project_id" style="width: 100%; padding: 8px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box;">
                        <option value="">-- Tất cả --</option>
                        <?php foreach ($projects as $proj): ?>
                            <option value="<?php echo $proj['id']; ?>" <?php echo ($filters['project_id'] ?? '') == $proj['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($proj['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📊 Trạng Thái</label>
                    <select name="status" style="width: 100%; padding: 8px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box;">
                        <option value="">-- Tất cả --</option>
                        <option value="todo" <?php echo ($filters['status'] ?? '') == 'todo' ? 'selected' : ''; ?>>Chưa làm</option>
                        <option value="in_progress" <?php echo ($filters['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>Đang làm</option>
                        <option value="completed" <?php echo ($filters['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                    </select>
                </div>
                
                <?php if (!empty($users)): ?>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">👤 Người Được Gán</label>
                    <select name="assigned_to" style="width: 100%; padding: 8px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box;">
                        <option value="">-- Tất cả --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php echo ($filters['assigned_to'] ?? '') == $user['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($user['full_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
                <div style="display: flex; gap: 8px; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">🔎 Tìm</button>
                    <a href="<?php echo $baseUrl; ?>/tasks" class="btn btn-secondary" style="padding: 8px 16px;">Đặt Lại</a>
                </div>
            </form>
        </div>
        
        <?php if (!empty($tasks)): ?>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Tiêu Đề</th>
                            <th>Dự Án</th>
                            <th>Người Được Gán</th>
                            <th>Trạng Thái</th>
                            <th>Hạn Chót</th>
                            <th>Tiến Độ</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td><?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($task['assigned_name'] ?? 'Chưa gán'); ?></td>
                                <td>
                                    <span style="background: <?php echo $task['status'] == 'todo' ? '#95a5a6' : ($task['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                                        <?php 
                                            $statusMap = [
                                                'todo' => 'Chưa làm',
                                                'in_progress' => 'Đang làm',
                                                'completed' => 'Hoàn thành'
                                            ];
                                            echo $statusMap[$task['status']] ?? $task['status'];
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo $task['due_date'] ? date('d/m/Y', strtotime($task['due_date'])) : 'N/A'; ?></td>
                                <td>
                                    <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 20px;">
                                        <div style="background: #3498db; height: 100%; width: <?php echo $task['progress']; ?>%;"></div>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem</a>
                                    <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>/edit" class="btn btn-warning" style="font-size: 12px; padding: 6px 12px;">Sửa</a>
                                    <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>/delete" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px; margin-top: 4px;" onclick="return confirm('Bạn có chắc chắn?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card">
                <p>Không có tác vụ nào. <a href="<?php echo $baseUrl; ?>/tasks/create">Tạo tác vụ đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php else: ?>
<!-- USER VIEW -->
<div style="max-width: 1200px; margin: 0 auto;">
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">✓ Tác Vụ Của Tôi</h2>
            <a href="<?php echo $baseUrl; ?>/dashboard" class="btn btn-primary">← Quay Lại Dashboard</a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card" style="margin-bottom: 20px; background: #f8f9fa;">
        <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">🔍 Tìm kiếm</label>
                <input type="text" name="search" placeholder="Tiêu đề hoặc mô tả..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="width: 100%; padding: 8px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box;">
            </div>
            
            <?php if (!empty($projects)): ?>
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📌 Dự Án</label>
                <select name="project_id" style="width: 100%; padding: 8px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box;">
                    <option value="">-- Tất cả --</option>
                    <?php foreach ($projects as $proj): ?>
                        <option value="<?php echo $proj['id']; ?>" <?php echo ($filters['project_id'] ?? '') == $proj['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($proj['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            
            <div>
                <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📊 Trạng Thái</label>
                <select name="status" style="width: 100%; padding: 8px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box;">
                    <option value="">-- Tất cả --</option>
                    <option value="todo" <?php echo ($filters['status'] ?? '') == 'todo' ? 'selected' : ''; ?>>Chưa làm</option>
                    <option value="in_progress" <?php echo ($filters['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>Đang làm</option>
                    <option value="completed" <?php echo ($filters['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                </select>
            </div>
            
            <div style="display: flex; gap: 8px; align-items: flex-end;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">🔎 Tìm</button>
                <a href="<?php echo $baseUrl; ?>/tasks" class="btn btn-secondary" style="padding: 8px 16px;">Đặt Lại</a>
            </div>
        </form>
    </div>
    
    <?php if (!empty($overdue)): ?>
        <div class="card" style="margin-bottom: 20px; border-left: 4px solid #e74c3c;">
            <h3 style="color: #e74c3c; margin-top: 0;">⚠️ Tác Vụ Quá Hạn (<?php echo count($overdue); ?>)</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px;">
                <?php foreach ($overdue as $task): ?>
                    <div style="border: 1px solid #e74c3c; border-radius: 4px; padding: 12px; background: #fff5f5;">
                        <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="text-decoration: none; color: #2c3e50;">
                            <h4 style="margin: 0 0 8px 0; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></h4>
                        </a>
                        <p style="margin: 4px 0; font-size: 13px; color: #666;">
                            <strong>Dự án:</strong> <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                        </p>
                        <p style="margin: 4px 0; font-size: 13px; color: #e74c3c;">
                            <strong>Hạn chót:</strong> <?php echo date('d/m/Y', strtotime($task['due_date'])); ?>
                        </p>
                        <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" class="btn btn-danger" style="width: 100%; text-align: center; margin-top: 8px;">Xem Ngay</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($upcoming)): ?>
        <div class="card" style="margin-bottom: 20px; border-left: 4px solid #f39c12;">
            <h3 style="color: #f39c12; margin-top: 0;">⏰ Tác Vụ Sắp Tới (<?php echo count($upcoming); ?>)</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px;">
                <?php foreach ($upcoming as $task): ?>
                    <div style="border: 1px solid #f39c12; border-radius: 4px; padding: 12px; background: #fffbf0;">
                        <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="text-decoration: none; color: #2c3e50;">
                            <h4 style="margin: 0 0 8px 0; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></h4>
                        </a>
                        <p style="margin: 4px 0; font-size: 13px; color: #666;">
                            <strong>Dự án:</strong> <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                        </p>
                        <p style="margin: 4px 0; font-size: 13px; color: #f39c12;">
                            <strong>Hạn chót:</strong> <?php echo date('d/m/Y', strtotime($task['due_date'])); ?>
                        </p>
                        <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" class="btn btn-warning" style="width: 100%; text-align: center; margin-top: 8px;">Xem Chi Tiết</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($tasks)): ?>
        <div class="card">
            <h3>📋 Các Tác Vụ Khác</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px;">
                <?php foreach ($tasks as $task): ?>
                    <div style="border: 1px solid #ddd; border-radius: 4px; padding: 12px; background: white; transition: transform 0.2s;">
                        <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="text-decoration: none; color: #2c3e50;">
                            <h4 style="margin: 0 0 8px 0; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></h4>
                        </a>
                        <p style="margin: 4px 0; font-size: 13px; color: #666;">
                            <strong>Dự án:</strong> <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                        </p>
                        <p style="margin: 4px 0; font-size: 13px; color: #666;">
                            <strong>Trạng thái:</strong>
                            <span style="background: <?php echo $task['status'] == 'todo' ? '#95a5a6' : ($task['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">
                                <?php 
                                    $statusMap = [
                                        'todo' => 'Chưa làm',
                                        'in_progress' => 'Đang làm',
                                        'completed' => 'Hoàn thành'
                                    ];
                                    echo $statusMap[$task['status']] ?? $task['status'];
                                ?>
                            </span>
                        </p>
                        <?php if ($task['progress']): ?>
                            <p style="margin: 8px 0 4px 0; font-size: 13px; color: #666;">
                                <strong>Tiến độ:</strong>
                            </p>
                            <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 20px; margin-bottom: 8px;">
                                <div style="background: #3498db; height: 100%; width: <?php echo $task['progress']; ?>%; display: flex; align-items: center; justify-content: center; color: white; font-size: 11px; font-weight: bold;">
                                    <?php echo $task['progress']; ?>%
                                </div>
                            </div>
                        <?php endif; ?>
                        <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" class="btn btn-primary" style="width: 100%; text-align: center; padding: 8px;">Xem Chi Tiết</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (empty($tasks) && empty($overdue) && empty($upcoming)): ?>
        <div class="card" style="text-align: center; padding: 40px;">
            <p style="font-size: 16px; color: #666; margin-bottom: 20px;">
                📭 Bạn hiện chưa có tác vụ nào được gán.
            </p>
            <p style="color: #999; margin-bottom: 20px;">
                Hãy liên hệ với quản trị viên hoặc xem các dự án được gán cho bạn.
            </p>
            <a href="<?php echo $baseUrl; ?>/dashboard" class="btn btn-primary">← Quay Lại Dashboard</a>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
