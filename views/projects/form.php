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
    
    <div class="main-content">
        <div class="card">
            <h2><?php echo isset($project) ? '✏️ Chỉnh Sửa Dự Án' : '➕ Tạo Dự Án Mới'; ?></h2>
            <p style="color: #666; margin-bottom: 20px;">
                <?php echo isset($project) ? 'Cập nhật thông tin dự án' : 'Tạo một dự án mới và gán cho một nhóm'; ?>
            </p>
            
            <form method="POST" action="<?php echo isset($project) ? $baseUrl . '/projects/' . $project['id'] . '/edit' : $baseUrl . '/projects/create'; ?>">
                <div class="form-group">
                    <label for="name"><strong>📝 Tên Dự Án</strong> <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" required 
                           value="<?php echo htmlspecialchars($project['name'] ?? ''); ?>"
                           placeholder="Ví dụ: Hệ thống quản lý, Website bán hàng..."
                           style="width: 100%; padding: 10px;">
                    <small style="color: #999;">Tên duy nhất và mô tả rõ dự án</small>
                </div>
                
                <div class="form-group">
                    <label for="description"><strong>📄 Mô Tả</strong></label>
                    <textarea id="description" name="description" 
                              placeholder="Mô tả chi tiết về dự án, yêu cầu, mục tiêu..."
                              style="width: 100%; padding: 10px; min-height: 100px; font-family: Arial, sans-serif;">
<?php echo htmlspecialchars($project['description'] ?? ''); ?></textarea>
                    <small style="color: #999;">Tùy chọn - Giúp team hiểu rõ mục tiêu dự án</small>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="category_id"><strong>📑 Danh Mục</strong> <span style="color: red;">*</span></label>
                        <?php if (!empty($categories)): ?>
                            <select id="category_id" name="category_id" required style="width: 100%; padding: 10px;">
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
                        <small style="color: #999;">Phân loại dự án theo danh mục</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="team_id"><strong>👨‍💼 Nhóm Được Gán</strong> <span style="color: red;">*</span></label>
                        <?php if (!empty($teams)): ?>
                            <select id="team_id" name="team_id" required style="width: 100%; padding: 10px;">
                                <option value="">-- Chọn nhóm --</option>
                                <?php foreach ($teams as $team): ?>
                                    <option value="<?php echo $team['id']; ?>" <?php echo (isset($project) && $project['team_id'] == $team['id']) ? 'selected' : ''; ?>>
                                        👥 <?php echo htmlspecialchars($team['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <div style="padding: 10px; background: #fff3cd; border-radius: 4px; color: #856404;">
                                ⚠️ Chưa có nhóm nào. Vui lòng <a href="<?php echo $baseUrl; ?>/teams/create" style="color: #856404; font-weight: bold;">tạo nhóm</a> trước.
                            </div>
                        <?php endif; ?>
                        <small style="color: #999;">Những người trong nhóm sẽ thấy dự án này</small>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="status"><strong>🔘 Trạng Thái</strong></label>
                        <select id="status" name="status" style="width: 100%; padding: 10px;">
                            <option value="planning" <?php echo (isset($project) && $project['status'] == 'planning') ? 'selected' : ''; ?>>📋 Lên kế hoạch</option>
                            <option value="in_progress" <?php echo (isset($project) && $project['status'] == 'in_progress') ? 'selected' : ''; ?>>🔄 Đang tiến hành</option>
                            <option value="completed" <?php echo (isset($project) && $project['status'] == 'completed') ? 'selected' : ''; ?>>✓ Hoàn thành</option>
                            <option value="cancelled" <?php echo (isset($project) && $project['status'] == 'cancelled') ? 'selected' : ''; ?>>✗ Hủy</option>
                        </select>
                        <small style="color: #999;">Trạng thái hiện tại của dự án</small>
                    </div>

                    <div class="form-group">
                        <label for="progress"><strong>📊 Tiến Độ</strong></label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="number" id="progress" name="progress" min="0" max="100" 
                                   value="<?php echo htmlspecialchars($project['progress'] ?? 0); ?>"
                                   style="width: 100%; padding: 10px;">
                            <span style="white-space: nowrap;">%</span>
                        </div>
                        <small style="color: #999;">0-100% (Cập nhật tự động từ tác vụ)</small>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="start_date"><strong>📅 Ngày Bắt Đầu</strong></label>
                        <input type="date" id="start_date" name="start_date" 
                               value="<?php echo htmlspecialchars($project['start_date'] ?? ''); ?>"
                               style="width: 100%; padding: 10px;">
                        <small style="color: #999;">Tùy chọn</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date"><strong>📅 Ngày Kết Thúc</strong></label>
                        <input type="date" id="end_date" name="end_date" 
                               value="<?php echo htmlspecialchars($project['end_date'] ?? ''); ?>"
                               style="width: 100%; padding: 10px;">
                        <small style="color: #999;">Tùy chọn</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="budget"><strong>💰 Ngân Sách</strong></label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <span>₫</span>
                        <?php $budget = isset($project['budget']) ? htmlspecialchars($project['budget']) : ''; ?>
                        <input type="number" id="budget" name="budget" step="0.01" 
                               value="<?php echo $budget; ?>"
                               placeholder="Ví dụ: 50000000"
                               style="width: 100%; padding: 10px;">
                    </div>
                    <small style="color: #999;">Tùy chọn - Ngân sách dự kiến cho dự án</small>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn btn-success" style="padding: 12px 24px; font-weight: bold; cursor: pointer;" <?php echo (empty($categories) || empty($teams)) ? 'disabled' : ''; ?>>
                        <?php echo isset($project) ? '💾 Cập Nhật' : '💾 Tạo Dự Án'; ?>
                    </button>
                    <a href="<?php echo $baseUrl; ?>/projects" class="btn btn-primary" style="padding: 12px 24px;">← Quay Lại Danh Sách</a>
                </div>
            </form>
        </div>
    </div>
</div>
