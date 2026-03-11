<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="/du_an_xuong/public/projects">📌 Dự án</a>
    </div>
    
    <div class="main-content">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;"><?php echo htmlspecialchars($project['name']); ?></h2>
                <div style="display: flex; gap: 10px;">
                    <a href="/du_an_xuong/public/projects/<?php echo $project['id']; ?>/edit" class="btn btn-warning">Sửa</a>
                    <a href="/du_an_xuong/public/projects" class="btn btn-primary">← Quay Lại</a>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <p><strong>Danh Mục:</strong> <?php echo htmlspecialchars($project['category_name'] ?? 'N/A'); ?></p>
                    <p><strong>Người Theo Dõi:</strong> <?php echo htmlspecialchars($project['assigned_name'] ?? 'Chưa gán'); ?></p>
                    <p><strong>Trạng Thái:</strong> 
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
                    </p>
                </div>
                <div>
                    <p><strong>Ngày Bắt Đầu:</strong> <?php echo $project['start_date'] ? date('d/m/Y', strtotime($project['start_date'])) : 'N/A'; ?></p>
                    <p><strong>Ngày Kết Thúc:</strong> <?php echo $project['end_date'] ? date('d/m/Y', strtotime($project['end_date'])) : 'N/A'; ?></p>
                    <p><strong>Ngân Sách:</strong> <?php echo number_format($project['budget'] ?? 0, 0, ',', '.'); ?> VND</p>
                </div>
            </div>
            
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ecf0f1;">
            
            <div>
                <h3>Mô Tả</h3>
                <p><?php echo htmlspecialchars($project['description'] ?? 'Không có mô tả'); ?></p>
            </div>
        </div>
        
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Tiến Độ Dự Án</h2>
            </div>
            <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 30px;">
                <div style="background: #3498db; height: 100%; width: <?php echo $project['progress']; ?>%; text-align: center; color: white; line-height: 30px;">
                    <?php echo $project['progress']; ?>%
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>Tác Vụ của Dự Án</h2>
            <?php if (!empty($tasks)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tiêu Đề</th>
                            <th>Người Được Gán</th>
                            <th>Trạng Thái</th>
                            <th>Tiến Độ</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
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
                                <td>
                                    <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 20px;">
                                        <div style="background: #3498db; height: 100%; width: <?php echo $task['progress']; ?>%;"></div>
                                    </div>
                                </td>
                                <td>
                                    <a href="/du_an_xuong/public/tasks/<?php echo $task['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Không có tác vụ nào trong dự án này.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
