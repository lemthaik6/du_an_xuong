<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/projects">📌 Dự án</a>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Tác vụ</a>
    </div>
    
    <div class="main-content">
        <div class="card" style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Danh Sách Tác Vụ</h2>
                <a href="<?php echo $baseUrl; ?>/tasks/create" class="btn btn-success">+ Tạo Tác Vụ</a>
            </div>
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
                <p>Không có tác vụ nào. <a href="/du_an_xuong/public/tasks/create">Tạo tác vụ đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
