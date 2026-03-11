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
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0;">👥 Thành Viên Đội</h2>
                <a href="#" onclick="openAddMemberForm('<?php echo $team['id']; ?>')" class="btn btn-success">+ Thêm Thành Viên</a>
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
                                <td><?php echo htmlspecialchars($member['position'] ?? 'N/A'); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($member['joined_at'])); ?></td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/remove-member/<?php echo $member['user_id']; ?>" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px;" onclick="return confirm('Bạn có chắc chắn?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Chưa có thành viên nào trong đội.</p>
            <?php endif; ?>
        </div>
        
        <!-- Add Member Modal -->
        <div id="addMemberModal" style="display: none; margin-top: 20px;">
            <div class="card">
                <h2>Thêm Thành Viên Mới</h2>
                <form method="POST" action="<?php echo $baseUrl; ?>/teams/add-member">
                    <input type="hidden" name="team_id" id="team_id" value="">
                    
                    <div class="form-group">
                        <label for="user_id">Người Dùng</label>
                        <select id="user_id" name="user_id" required>
                            <option value="">-- Chọn người dùng --</option>
                            <?php if (isset($available_users)): ?>
                                <?php foreach ($available_users as $user): ?>
                                    <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="position">Vị Trí</label>
                        <input type="text" id="position" name="position" placeholder="Ví dụ: Frontend Developer">
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-success">Thêm Thành Viên</button>
                        <button type="button" class="btn btn-primary" onclick="closeAddMemberForm()">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
function openAddMemberForm(teamId) {
    document.getElementById('team_id').value = teamId;
    document.getElementById('addMemberModal').style.display = 'block';
}

function closeAddMemberForm() {
    document.getElementById('addMemberModal').style.display = 'none';
}
</script>
