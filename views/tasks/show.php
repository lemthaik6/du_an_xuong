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

<?php else: ?>
<!-- USER VIEW -->
<div style="max-width: 900px; margin: 0 auto;">
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: start; gap: 20px;">
            <div style="flex: 1;">
                <h2 style="margin: 0 0 12px 0; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></h2>
                <p style="color: #666; margin: 0;">
                    <strong>Dự án:</strong> <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                </p>
            </div>
            <span style="background: <?php echo $task['status'] == 'todo' ? '#95a5a6' : ($task['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 8px 12px; border-radius: 4px; white-space: nowrap;">
                <?php 
                    $statusMap = [
                        'todo' => '⭕ Chưa làm',
                        'in_progress' => '🔄 Đang làm',
                        'completed' => '✔️ Hoàn thành'
                    ];
                    echo $statusMap[$task['status']] ?? $task['status'];
                ?>
            </span>
        </div>
    </div>
    
    <div class="card" style="margin-bottom: 20px;">
        <h3 style="margin-top: 0;">📝 Mô Tả</h3>
        <p style="color: #333; line-height: 1.6;"><?php echo nl2br(htmlspecialchars($task['description'] ?? 'Không có mô tả')); ?></p>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="card">
            <h3 style="margin-top: 0;">📅 Thông Tin</h3>
            <p style="margin: 8px 0;">
                <strong>Hạn chót:</strong><br>
                <?php echo $task['due_date'] ? date('d/m/Y', strtotime($task['due_date'])) : 'Không có'; ?>
            </p>
            <p style="margin: 8px 0;">
                <strong>Người tạo:</strong><br>
                <?php echo htmlspecialchars($task['created_name'] ?? 'N/A'); ?>
            </p>
        </div>
        
        <div class="card">
            <h3 style="margin-top: 0;">📊 Tiến Độ</h3>
            <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 40px; margin-bottom: 8px;">
                <div style="background: linear-gradient(90deg, #3498db, #2980b9); height: 100%; width: <?php echo $task['progress']; ?>%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                    <?php echo $task['progress']; ?>%
                </div>
            </div>
        </div>
    </div>
    
    <?php if (!empty($attachments)): ?>
        <div class="card" style="margin-bottom: 20px;">
            <h3 style="margin-top: 0;">📎 Tệp Đính Kèm</h3>
            <div style="display: grid; gap: 10px;">
                <?php foreach ($attachments as $attachment): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border: 1px solid #ecf0f1; border-radius: 4px;">
                        <div>
                            <p style="margin: 0; font-weight: 500;"><?php echo htmlspecialchars($attachment['file_name']); ?></p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #999;">
                                <?php echo number_format($attachment['file_size'] / 1024, 2) . ' KB'; ?> • <?php echo htmlspecialchars($attachment['uploader_name'] ?? 'N/A'); ?>
                            </p>
                        </div>
                        <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>" class="btn btn-primary" style="padding: 6px 16px;" download>Tải</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="card" style="margin-bottom: 20px;">
        <h3 style="margin-top: 0;">💬 Bình Luận</h3>
        
        <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
            <form method="POST" action="<?php echo $baseUrl; ?>/tasks/add-comment">
                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                <div class="form-group">
                    <textarea name="content" placeholder="Nhập bình luận của bạn..." required style="min-height: 80px;"></textarea>
                </div>
                <button type="submit" class="btn btn-success">💬 Gửi Bình Luận</button>
            </form>
        </div>
        
        <?php if (!empty($comments)): ?>
            <div style="display: grid; gap: 12px;">
                <?php foreach ($comments as $comment): ?>
                    <div style="padding: 12px; background: #f8f9fa; border-left: 4px solid #3498db; border-radius: 4px;">
                        <p style="margin: 0; font-weight: 500;">
                            <?php echo htmlspecialchars($comment['user_name'] ?? 'Ẩn danh'); ?>
                            <span style="color: #999; font-size: 12px; font-weight: normal;">
                                - <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?>
                            </span>
                        </p>
                        <p style="margin: 8px 0 0 0; color: #333;">
                            <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color: #999; text-align: center; padding: 20px 0;">
                Chưa có bình luận nào. Hãy là người đầu tiên bình luận!
            </p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <a href="<?php echo $baseUrl; ?>/tasks" class="btn btn-primary">← Quay Lại Danh Sách Tác Vụ</a>
    </div>
</div>
<?php endif; ?>
