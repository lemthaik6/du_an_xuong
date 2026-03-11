<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Tác vụ</a>
    </div>
    
    <div class="main-content">
        <div class="card">
            <h2><?php echo isset($task) ? 'Chỉnh Sửa Tác Vụ' : 'Tạo Tác Vụ Mới'; ?></h2>
            
            <form method="POST" action="<?php echo isset($task) ? $baseUrl . '/tasks/' . $task['id'] . '/edit' : $baseUrl . '/tasks/create'; ?>">
                <div class="form-group">
                    <label for="title">Tiêu Đề</label>
                    <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($task['title'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($task['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="project_id">Dự Án</label>
                    <select id="project_id" name="project_id" required>
                        <option value="">-- Chọn dự án --</option>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?php echo $project['id']; ?>" <?php echo (isset($task) && $task['project_id'] == $project['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($project['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="assigned_to">Người Được Gán</label>
                    <select id="assigned_to" name="assigned_to">
                        <option value="">-- Chưa gán --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php echo (isset($task) && $task['assigned_to'] == $user['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($user['full_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="todo" <?php echo (isset($task) && $task['status'] == 'todo') ? 'selected' : ''; ?>>Chưa làm</option>
                        <option value="in_progress" <?php echo (isset($task) && $task['status'] == 'in_progress') ? 'selected' : ''; ?>>Đang làm</option>
                        <option value="completed" <?php echo (isset($task) && $task['status'] == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                    </select>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="due_date">Hạn Chót</label>
                        <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="progress">Tiến Độ (%)</label>
                        <input type="number" id="progress" name="progress" min="0" max="100" value="<?php echo htmlspecialchars($task['progress'] ?? 0); ?>">
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">💾 Lưu</button>
                    <a href="<?php echo $baseUrl; ?>/tasks" class="btn btn-primary">← Quay Lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
