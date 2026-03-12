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
            <h2><?php echo isset($team) ? '✏️ Chỉnh Sửa Đội Nhóm' : '➕ Tạo Đội Nhóm Mới'; ?></h2>
            <p style="color: #666; margin-bottom: 20px;">
                <?php echo isset($team) ? 'Cập nhật thông tin đội nhóm' : 'Tạo một đội nhóm mới để quản lý dự án'; ?>
            </p>
            
            <form method="POST" action="<?php echo isset($team) ? $baseUrl . '/teams/' . $team['id'] . '/edit' : $baseUrl . '/teams/create'; ?>">
                <div class="form-group">
                    <label for="name"><strong>📝 Tên Đội Nhóm</strong> <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" required 
                           value="<?php echo htmlspecialchars($team['name'] ?? ''); ?>"
                           placeholder="Ví dụ: Frontend Team, Backend Team, Design Team..."
                           style="width: 100%; padding: 10px;">
                    <small style="color: #999;">Tên duy nhất và dễ nhớ cho đội nhóm</small>
                </div>
                
                <div class="form-group">
                    <label for="description"><strong>📄 Mô Tả</strong></label>
                    <textarea id="description" name="description" placeholder="Mô tả chi tiết về đội nhóm, nhiệm vụ, lĩnh vực chuyên môn..." 
                              style="width: 100%; padding: 10px; min-height: 100px; font-family: Arial, sans-serif;">
<?php echo htmlspecialchars($team['description'] ?? ''); ?></textarea>
                    <small style="color: #999;">Tùy chọn - Giúp các thành viên hiểu rõ mục đích của đội</small>
                </div>
                
                <div class="form-group">
                    <label for="leader_id"><strong>👨‍💼 Lãnh Đạo Đội</strong> <span style="color: red;">*</span></label>
                    <select id="leader_id" name="leader_id" required style="width: 100%; padding: 10px;">
                        <option value="">-- Chọn lãnh đạo --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php echo (isset($team) && $team['leader_id'] == $user['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($user['full_name']); ?> (<?php echo htmlspecialchars($user['email']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small style="color: #999;">Chọn người sẽ quản lý đội nhóm này</small>
                </div>
                
                <div class="form-group">
                    <label for="status"><strong>🔘 Trạng Thái</strong></label>
                    <select id="status" name="status" style="width: 100%; padding: 10px;">
                        <option value="active" <?php echo (isset($team) && $team['status'] == 'active') ? 'selected' : 'selected'; ?>>
                            ✓ Hoạt động
                        </option>
                        <option value="inactive" <?php echo (isset($team) && $team['status'] == 'inactive') ? 'selected' : ''; ?>>
                            ✗ Vô hiệu
                        </option>
                    </select>
                    <small style="color: #999;">Đội vô hiệu sẽ không nhìn thấy trong danh sách chính</small>
                </div>
                
                <?php if (isset($team) && !empty($team['id'])): ?>
                    <div style="background: #f0f0f0; padding: 15px; border-radius: 4px; margin: 20px 0;">
                        <h4 style="margin: 0 0 10px 0;">ℹ️ Thông Tin Đội Nhóm</h4>
                        <p style="margin: 5px 0;"><strong>ID:</strong> <?php echo $team['id']; ?></p>
                        <p style="margin: 5px 0;"><strong>Tạo bởi:</strong> <?php echo $team['created_by'] ?? 'N/A'; ?></p>
                    </div>
                <?php endif; ?>
                
                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn btn-success" style="padding: 12px 24px; font-weight: bold; cursor: pointer;">
                        <?php echo isset($team) ? '💾 Cập Nhật' : '💾 Tạo Đội'; ?>
                    </button>
                    <a href="<?php echo $baseUrl; ?>/teams" class="btn btn-primary" style="padding: 12px 24px;">← Quay Lại Danh Sách</a>
                </div>
            </form>
        </div>
    </div>
</div>
