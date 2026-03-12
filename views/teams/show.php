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
                <h2 style="margin: 0;"><?php echo htmlspecialchars($team['name']); ?></h2>
                <div style="display: flex; gap: 10px;">
                    <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/edit" class="btn btn-warning">Sửa</a>
                    <a href="<?php echo $baseUrl; ?>/teams" class="btn btn-primary">← Quay Lại</a>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <p><strong>Mô Tả:</strong> <?php echo htmlspecialchars($team['description'] ?? 'Không có mô tả'); ?></p>
                    <p><strong>Lãnh Đạo:</strong> <?php echo htmlspecialchars($team['leader_name'] ?? 'N/A'); ?></p>
                </div>
                <div>
                    <p><strong>Trạng Thái:</strong> 
                        <span style="background: <?php echo $team['status'] == 'active' ? '#27ae60' : '#95a5a6'; ?>; color: white; padding: 4px 8px; border-radius: 4px;">
                            <?php echo $team['status'] == 'active' ? 'Hoạt động' : 'Vô hiệu'; ?>
                        </span>
                    </p>
                    <p><strong>Số Thành Viên:</strong> <?php echo count($members); ?></p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">👥 Thành Viên Đội</h2>
                <button onclick="openAddMemberForm('<?php echo $team['id']; ?>')" class="btn btn-success" style="cursor: pointer;">+ Thêm Thành Viên</button>
            </div>
            
            <?php if (!empty($members)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Họ và Tên</th>
                            <th>Email</th>
                            <th>Vị Trí</th>
                            <th>Ngày Tham Gia</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td>
                                    <?php if (!empty($member['position'])): ?>
                                        <span style="background: #ecf0f1; padding: 4px 8px; border-radius: 4px;">
                                            <?php echo htmlspecialchars($member['position']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #999;">Chưa cập nhật</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $member['joined_at'] ? date('d/m/Y', strtotime($member['joined_at'])) : 'N/A'; ?></td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/remove-member/<?php echo $member['id']; ?>" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px;" onclick="return confirm('Xóa thành viên này khỏi đội?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color: #999; font-style: italic;">Chưa có thành viên nào trong đội. <a href="#" onclick="openAddMemberForm('<?php echo $team['id']; ?>'); return false;">Thêm thành viên đầu tiên</a></p>
            <?php endif; ?>
        </div>
        
        <!-- Add Member Modal -->
        <div id="addMemberModal" style="display: none; margin-top: 20px;">
            <div class="card" style="background: #f8f9fa; border: 2px solid #3498db;">
                <h3 style="margin-top: 0; color: #3498db;">➕ Thêm Thành Viên Mới</h3>
                <form method="POST" action="<?php echo $baseUrl; ?>/teams/add-member" onsubmit="return validateAddMemberForm()">
                    <input type="hidden" name="team_id" id="team_id" value="">
                    
                    <div class="form-group">
                        <label for="user_id"><strong>👤 Người Dùng</strong> <span style="color: red;">*</span></label>
                        <select id="user_id" name="user_id" required>
                            <option value="">-- Chọn người dùng --</option>
                            <?php if (isset($available_users)): ?>
                                <?php foreach ($available_users as $user): ?>
                                    <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?> (<?php echo htmlspecialchars($user['email']); ?>)</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small style="color: #999;">Chọn một người dùng từ danh sách</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="position"><strong>💼 Vị Trí/Chức Vụ</strong></label>
                        <input type="text" id="position" name="position" placeholder="Ví dụ: Frontend Developer, Project Manager..." style="width: 100%; padding: 10px;">
                        <small style="color: #999;">Tùy chọn - Mô tả vị trí/chức vụ của thành viên trong đội</small>
                    </div>
                    
                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-success" style="cursor: pointer;">✓ Thêm Thành Viên</button>
                        <button type="button" class="btn btn-secondary" onclick="closeAddMemberForm()" style="cursor: pointer;">✕ Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openAddMemberForm(teamId) {
    document.getElementById('team_id').value = teamId;
    document.getElementById('user_id').value = '';
    document.getElementById('position').value = '';
    document.getElementById('addMemberModal').style.display = 'block';
    document.getElementById('user_id').focus();
}

function closeAddMemberForm() {
    document.getElementById('addMemberModal').style.display = 'none';
    document.getElementById('user_id').value = '';
    document.getElementById('position').value = '';
}

function validateAddMemberForm() {
    const userId = document.getElementById('user_id').value;
    if (!userId) {
        alert('Vui lòng chọn người dùng');
        document.getElementById('user_id').focus();
        return false;
    }
    return true;
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('addMemberModal');
    if (event.target === modal) {
        closeAddMemberForm();
    }
});
</script>
