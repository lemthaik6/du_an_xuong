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
            <h2><?php echo isset($project) ? 'Chỉnh Sửa Dự Án' : 'Tạo Dự Án Mới'; ?></h2>
            
            <form method="POST" action="<?php echo isset($project) ? $baseUrl . '/projects/' . $project['id'] . '/edit' : $baseUrl . '/projects/create'; ?>">
                <div class="form-group">
                    <label for="name">Tên Dự Án</label>
                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($project['name'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($project['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="category_id">Danh Mục</label>
                    <?php if (!empty($categories)): ?>
                        <select id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo (isset($project) && $project['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <div style="padding: 10px; background: #fff3cd; border-radius: 4px; color: #856404;">
                            ⚠️ Chưa có danh mục nào. Vui lòng <a href="<?php echo $baseUrl; ?>/categories/create" style="color: #856404; font-weight: bold;">tạo danh mục</a> trước.
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="assigned_to">Người Theo Dõi</label>
                    <select id="assigned_to" name="assigned_to">
                        <option value="">-- Chưa gán --</option>
                        <?php foreach ($users ?? [] as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php echo (isset($project) && $project['assigned_to'] == $user['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($user['full_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="planning" <?php echo (isset($project) && $project['status'] == 'planning') ? 'selected' : ''; ?>>Lên kế hoạch</option>
                        <option value="in_progress" <?php echo (isset($project) && $project['status'] == 'in_progress') ? 'selected' : ''; ?>>Đang tiến hành</option>
                        <option value="completed" <?php echo (isset($project) && $project['status'] == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                        <option value="cancelled" <?php echo (isset($project) && $project['status'] == 'cancelled') ? 'selected' : ''; ?>>Hủy</option>
                    </select>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="start_date">Ngày Bắt Đầu</label>
                        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($project['start_date'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date">Ngày Kết Thúc</label>
                        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($project['end_date'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="budget">Ngân Sách</label>
                    <input type="number" id="budget" name="budget" step="0.01" value="<?php echo htmlspecialchars($project['budget'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="progress">Tiến Độ (%)</label>
                    <input type="number" id="progress" name="progress" min="0" max="100" value="<?php echo htmlspecialchars($project['progress'] ?? 0); ?>">
                    <small style="color: #999;">0-100%</small>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success" <?php echo empty($categories) ? 'disabled' : ''; ?>>💾 Lưu</button>
                    <a href="<?php echo $baseUrl; ?>/projects" class="btn btn-primary">← Quay Lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
