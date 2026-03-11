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
            <h2><?php echo isset($team) ? 'Chỉnh Sửa Đội Nhóm' : 'Tạo Đội Nhóm Mới'; ?></h2>
            
            <form method="POST" action="<?php echo isset($team) ? $baseUrl . '/teams/' . $team['id'] . '/edit' : $baseUrl . '/teams/create'; ?>">
                <div class="form-group">
                    <label for="name">Tên Đội Nhóm</label>
                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($team['name'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($team['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="leader_id">Lãnh Đạo</label>
                    <select id="leader_id" name="leader_id" required>
                        <option value="">-- Chọn lãnh đạo --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php echo (isset($team) && $team['leader_id'] == $user['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($user['full_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="active" <?php echo (isset($team) && $team['status'] == 'active') ? 'selected' : 'selected'; ?>>Hoạt động</option>
                        <option value="inactive" <?php echo (isset($team) && $team['status'] == 'inactive') ? 'selected' : ''; ?>>Vô hiệu</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">💾 Lưu</button>
                    <a href="<?php echo $baseUrl; ?>/teams" class="btn btn-primary">← Quay Lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
