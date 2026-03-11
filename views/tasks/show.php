<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Tác vụ</a>
    </div>
    
    <div class="main-content">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;"><?php echo htmlspecialchars($task['title']); ?></h2>
                <div style="display: flex; gap: 10px;">
                    <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>/edit" class="btn btn-warning">Sửa</a>
                    <a href="<?php echo $baseUrl; ?>/tasks" class="btn btn-primary">← Quay Lại</a>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <p><strong>Dự Án:</strong> <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?></p>
                    <p><strong>Người Được Gán:</strong> <?php echo htmlspecialchars($task['assigned_name'] ?? 'Chưa gán'); ?></p>
                    <p><strong>Trạng Thái:</strong> 
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
                    </p>
                </div>
                <div>
                    <p><strong>Hạn Chót:</strong> <?php echo $task['due_date'] ? date('d/m/Y', strtotime($task['due_date'])) : 'N/A'; ?></p>
                    <p><strong>Người Tạo:</strong> <?php echo htmlspecialchars($task['creator_name'] ?? 'N/A'); ?></p>
                    <p><strong>Ngày Tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($task['created_at'] ?? 'now')); ?></p>
                </div>
            </div>
            
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ecf0f1;">
            
            <div>
                <h3>Mô Tả</h3>
                <p><?php echo htmlspecialchars($task['description'] ?? 'Không có mô tả'); ?></p>
            </div>
        </div>
        
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">Tiến Độ</h2>
            </div>
            <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 30px;">
                <div style="background: #3498db; height: 100%; width: <?php echo $task['progress']; ?>%; text-align: center; color: white; line-height: 30px;">
                    <?php echo $task['progress']; ?>%
                </div>
            </div>
        </div>
        
        <?php if (!empty($attachments)): ?>
            <div class="card">
                <h2>📎 Tệp Đính Kèm</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Tên Tệp</th>
                            <th>Kích Thước</th>
                            <th>Người Tải</th>
                            <th>Ngày Tải</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attachments as $attachment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($attachment['file_name']); ?></td>
                                <td><?php echo number_format($attachment['file_size'] / 1024, 2) . ' KB'; ?></td>
                                <td><?php echo htmlspecialchars($attachment['uploader_name'] ?? 'N/A'); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($attachment['created_at'] ?? 'now')); ?></td>
                                <td>
                                    <a href="<?php echo  htmlspecialchars($attachment['file_path']); ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;" download>Tải Về</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <h2>💬 Bình Luận</h2>
            
            <div style="margin-bottom: 20px; border: 1px solid #ecf0f1; padding: 15px; border-radius: 4px;">
                <h4>Thêm Bình Luận</h4>
                <form method="POST" action="<?php echo $baseUrl; ?>/tasks/add-comment">
                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                    <div class="form-group">
                        <textarea name="content" placeholder="Nhập bình luận..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Gửi Bình Luận</button>
                </form>
            </div>
            
            <?php if (!empty($comments)): ?>
                <div>
                    <?php foreach ($comments as $comment): ?>
                        <div style="border: 1px solid #ecf0f1; padding: 15px; margin-bottom: 10px; border-radius: 4px;">
                            <p><strong><?php echo htmlspecialchars($comment['user_name'] ?? 'Ẩn danh'); ?></strong> 
                            <span style="color: #7f8c8d; font-size: 12px;"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></span></p>
                            <p><?php echo htmlspecialchars($comment['content']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Chưa có bình luận nào.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
