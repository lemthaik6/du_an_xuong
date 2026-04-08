<?php if ($isAdmin ?? false): ?>
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
                    <h2 style="margin: 0 0 10px 0; font-size: 28px;">✓ Quản Lý Tác Vụ</h2>
                    <p style="margin: 0; opacity: 0.9;">Quản lý tất cả tác vụ của hệ thống</p>
                </div>
                <a href="<?php echo $baseUrl; ?>/tasks/create" style="background: white; color: #667eea; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500;">+ Tạo Tác Vụ</a>
            </div>
        </div>

        <!-- Search & Filter Form -->
        <div class="card" style="margin-bottom: 20px; background: #f8f9fa; padding: 20px;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">🔍 Tìm kiếm</label>
                    <input type="text" name="search" placeholder="Tiêu đề hoặc mô tả..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                </div>
                
                <?php if (!empty($projects)): ?>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📌 Dự Án</label>
                    <select name="project_id" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
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
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                        <option value="">-- Tất cả --</option>
                        <option value="todo" <?php echo ($filters['status'] ?? '') == 'todo' ? 'selected' : ''; ?>>Chưa làm</option>
                        <option value="in_progress" <?php echo ($filters['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>Đang làm</option>
                        <option value="completed" <?php echo ($filters['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                    </select>
                </div>
                
                <?php if (!empty($users)): ?>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">👤 Người Được Gán</label>
                    <select name="assigned_to" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
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
                    <button type="submit" style="flex: 1; background: #3498db; color: white; padding: 10px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer;">🔎 Tìm</button>
                    <a href="<?php echo $baseUrl; ?>/tasks" style="background: #95a5a6; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 500;">Đặt Lại</a>
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
                                <td><strong><?php echo htmlspecialchars($task['title']); ?></strong></td>
                                <td><?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($task['assigned_name'] ?? 'Chưa gán'); ?></td>
                                <td>
                                    <span style="background: <?php echo $task['status'] == 'todo' ? '#95a5a6' : ($task['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px;">
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
                                        <div style="background: linear-gradient(90deg, #3498db, #2980b9); height: 100%; width: <?php echo $task['progress']; ?>%;"></div>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="background: #3498db; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500;">Xem</a>
                                    <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>/edit" style="background: #f39c12; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500; margin-left: 4px;">Sửa</a>
                                    <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>/delete" style="background: #e74c3c; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500; margin-left: 4px; margin-top: 4px;" onclick="return confirm('Bạn có chắc chắn?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="card" style="text-align: center; padding: 40px;">
                <p style="color: #999;">📭 Không có tác vụ nào. <a href="<?php echo $baseUrl; ?>/tasks/create" style="color: #3498db;">Tạo tác vụ đầu tiên</a></p>
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
            <h2 style="margin: 0 0 10px 0; font-size: 28px;">✓ Tác Vụ Của Tôi</h2>
            <p style="margin: 0; opacity: 0.9;">Các tác vụ được gán cho bạn</p>
        </div>

        <!-- Search Form -->
        <div class="card" style="margin-bottom: 20px; background: #f8f9fa; padding: 20px;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">🔍 Tìm kiếm</label>
                    <input type="text" name="search" placeholder="Tiêu đề hoặc mô tả..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                </div>
                
                <?php if (!empty($projects)): ?>
                <div>
                    <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">📌 Dự Án</label>
                    <select name="project_id" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
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
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 6px; box-sizing: border-box;">
                        <option value="">-- Tất cả --</option>
                        <option value="todo" <?php echo ($filters['status'] ?? '') == 'todo' ? 'selected' : ''; ?>>Chưa làm</option>
                        <option value="in_progress" <?php echo ($filters['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>Đang làm</option>
                        <option value="completed" <?php echo ($filters['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 8px; align-items: flex-end;">
                    <button type="submit" style="flex: 1; background: #3498db; color: white; padding: 10px 12px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer;">🔎 Tìm</button>
                    <a href="<?php echo $baseUrl; ?>/tasks" style="background: #95a5a6; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 500;">Đặt Lại</a>
                </div>
            </form>
        </div>
        
        <?php if (!empty($overdue)): ?>
            <div class="card" style="margin-bottom: 20px; border-left: 4px solid #e74c3c;">
                <h3 style="color: #e74c3c; margin-top: 0;">⚠️ Tác Vụ Quá Hạn (<?php echo count($overdue); ?>)</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
                    <?php foreach ($overdue as $task): ?>
                        <div class="card" style="border-left: 4px solid #e74c3c; background: #fff5f5;">
                            <h4 style="margin: 0 0 8px 0; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></h4>
                            <p style="margin: 4px 0; font-size: 13px; color: #666;">
                                <strong>📌 Dự án:</strong> <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                            </p>
                            <p style="margin: 4px 0; font-size: 13px; color: #e74c3c;">
                                <strong>📅 Hạn chót:</strong> <?php echo date('d/m/Y', strtotime($task['due_date'])); ?>
                            </p>
                            <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="background: #e74c3c; color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-weight: 500; display: block; text-align: center; margin-top: 8px;">Xem Ngay</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($upcoming)): ?>
            <div class="card" style="margin-bottom: 20px; border-left: 4px solid #f39c12;">
                <h3 style="color: #f39c12; margin-top: 0;">⏰ Tác Vụ Sắp Tới (<?php echo count($upcoming); ?>)</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
                    <?php foreach ($upcoming as $task): ?>
                        <div class="card" style="border-left: 4px solid #f39c12; background: #fffbf0;">
                            <h4 style="margin: 0 0 8px 0; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></h4>
                            <p style="margin: 4px 0; font-size: 13px; color: #666;">
                                <strong>📌 Dự án:</strong> <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                            </p>
                            <p style="margin: 4px 0; font-size: 13px; color: #f39c12;">
                                <strong>📅 Hạn chót:</strong> <?php echo date('d/m/Y', strtotime($task['due_date'])); ?>
                            </p>
                            <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="background: #f39c12; color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-weight: 500; display: block; text-align: center; margin-top: 8px;">Xem Chi Tiết</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($tasks)): ?>
            <div class="card">
                <h3 style="margin-top: 0;">📋 Các Tác Vụ Khác</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
                    <?php foreach ($tasks as $task): ?>
                        <div class="card" style="border-left: 4px solid <?php echo $task['status'] == 'todo' ? '#95a5a6' : ($task['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>;">
                            <h4 style="margin: 0 0 8px 0; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></h4>
                            <p style="margin: 4px 0; font-size: 13px; color: #666;">
                                <strong>📌 Dự án:</strong> <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                            </p>
                            <p style="margin: 4px 0; font-size: 13px; color: #666;">
                                <strong>📊 Trạng thái:</strong>
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
                                    <strong>Tiến độ:</strong> <span style="color: #3498db;"><?php echo $task['progress']; ?>%</span>
                                </p>
                                <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 20px; margin-bottom: 8px;">
                                    <div style="background: linear-gradient(90deg, #3498db, #2980b9); height: 100%; width: <?php echo $task['progress']; ?>%;"></div>
                                </div>
                            <?php endif; ?>
                            <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="background: #3498db; color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-weight: 500; display: block; text-align: center;">Xem Chi Tiết</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (empty($tasks) && empty($overdue) && empty($upcoming)): ?>
            <div class="card" style="text-align: center; padding: 60px 40px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                <p style="font-size: 48px; margin: 0 0 16px 0;">📭</p>
                <p style="font-size: 18px; color: #2c3e50; margin: 0 0 16px 0; font-weight: bold;">Chưa có tác vụ nào</p>
                <p style="color: #999; margin: 0 0 16px 0;">Bạn hiện chưa được gán tác vụ nào. Hãy liên hệ với quản trị viên.</p>
                <a href="<?php echo $baseUrl; ?>/dashboard" style="background: #3498db; color: white; padding: 10px 24px; border-radius: 6px; text-decoration: none; font-weight: 500;">← Quay Lại Dashboard</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
