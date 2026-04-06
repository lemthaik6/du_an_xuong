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
                <div>
                    <h2 style="margin: 0;"><?php echo htmlspecialchars($team['name']); ?></h2>
                    <p style="color: #7f8c8d; margin: 5px 0;">Quản lý thông tin và thành viên đội nhóm</p>
                </div>
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
                    <p><strong>Số Thành Viên:</strong> 
                        <span style="background: #3498db; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold;">
                            <?php echo !empty($members) ? count($members) : ($team['member_count'] ?? 0); ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">👥 Thành Viên Đội</h2>
                <button onclick="openAddMemberForm('<?php echo $team['id']; ?>')" class="btn btn-success" style="cursor: pointer;">+ Thêm Thành Viên</button>
            </div>
            
            <?php if (!empty($members) && is_array($members)): ?>
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
                                <td><?php echo htmlspecialchars($member['full_name'] ?? $member['username'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($member['email'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php if (!empty($member['position'])): ?>
                                        <span style="background: #ecf0f1; padding: 4px 8px; border-radius: 4px;">
                                            <?php echo htmlspecialchars($member['position']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #999;">Chưa cập nhật</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    if (!empty($member['joined_at'])) {
                                        echo date('d/m/Y', strtotime($member['joined_at']));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>/remove-member/<?php echo htmlspecialchars($member['id'] ?? $member['user_id'] ?? ''); ?>" class="btn btn-danger" style="font-size: 12px; padding: 6px 12px;" onclick="return confirm('Xóa thành viên này khỏi đội?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="background: #f8f9fa; padding: 30px; text-align: center; border-radius: 8px;">
                    <p style="color: #999; font-style: italic; margin: 0 0 15px 0;">
                        <?php 
                        if ($team['member_count'] > 0) {
                            echo '⚠️ Không thể hiển thị thành viên - có ' . $team['member_count'] . ' thành viên được ghi nhận nhưng không thể tải dữ liệu.';
                        } else {
                            echo '📭 Chưa có thành viên nào trong đội.';
                        }
                        ?>
                    </p>
                    <a href="#" onclick="openAddMemberForm('<?php echo $team['id']; ?>'); return false;" class="btn btn-success">+ Thêm thành viên đầu tiên</a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- TASK ASSIGNMENT SECTION -->
        <?php if ($isAdmin && !empty($tasks)): ?>
        <div class="card" style="background: #fef9e7; border: 2px solid #f39c12;">
            <h2 style="color: #d68910; margin-top: 0;">📋 Phân Công Tác Vụ Cho Thành Viên</h2>
            
            <p style="color: #666; margin-bottom: 20px;">
                Chọn tác vụ từ các dự án được gán cho đội này, rồi phân công cho thành viên.
            </p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div style="background: white; padding: 15px; border-radius: 5px;">
                    <h4 style="color: #333; margin-top: 0;">📌 Danh Sách Tác Vụ</h4>
                    <?php if (!empty($tasks)): ?>
                        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ecf0f1; border-radius: 4px;">
                            <?php foreach ($tasks as $task): ?>
                                <div style="padding: 10px; border-bottom: 1px solid #ecf0f1; cursor: pointer;" class="task-item" data-task-id="<?php echo $task['id']; ?>" onclick="selectTask(<?php echo $task['id']; ?>, '<?php echo htmlspecialchars(addslashes($task['title'])); ?>')">
                                    <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                                    <br>
                                    <small style="color: #7f8c8d;">Dự án: <?php echo htmlspecialchars($task['project_name']); ?></small>
                                    <br>
                                    <small style="color: #95a5a6;">
                                        Trạng thái: 
                                        <span style="background: <?php echo $task['status'] == 'todo' ? '#95a5a6' : ($task['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">
                                            <?php echo ucfirst($task['status']); ?>
                                        </span>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color: #e74c3c;">⚠️ Không có tác vụ nào cho đội này. Vui lòng gán dự án trước.</p>
                    <?php endif; ?>
                </div>
                
                <div style="background: white; padding: 15px; border-radius: 5px;">
                    <h4 style="color: #333; margin-top: 0;">👥 Chọn Thành Viên</h4>
                    <form method="POST" id="assignTaskForm" onsubmit="return updateTaskAction()">
                        <input type="hidden" name="task_id" id="selectedTaskId" value="">
                        
                        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ecf0f1; border-radius: 4px;">
                            <?php if (!empty($members) && is_array($members)): ?>
                                <?php foreach ($members as $member): ?>
                                    <label style="display: flex; align-items: center; gap: 10px; padding: 10px; cursor: pointer; border-bottom: 1px solid #ecf0f1;">
                                        <input type="checkbox" name="member_ids[]" value="<?php echo $member['id'] ?? $member['user_id'] ?? ''; ?>" style="width: 18px; height: 18px; cursor: pointer;">
                                        <span style="flex: 1;">
                                            <strong><?php echo htmlspecialchars($member['full_name'] ?? $member['username'] ?? 'N/A'); ?></strong>
                                            <br>
                                            <small style="color: #7f8c8d;">📧 <?php echo htmlspecialchars($member['email'] ?? 'N/A'); ?></small>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="color: #e74c3c;">⚠️ Đội này chưa có thành viên nào.</p>
                            <?php endif; ?>
                        </div>
                        
                        <div style="margin-top: 15px;">
                            <button type="submit" id="assignBtn" class="btn btn-success" style="width: 100%; padding: 10px; font-size: 14px; display: none;">
                                ✓ Phân Công Tác Vụ
                            </button>
                            <p id="selectTaskMsg" style="color: #e67e22; margin: 0; font-size: 12px;">Chọn tác vụ từ bên trái trước</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
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

// Task Assignment Functions
function selectTask(taskId, taskTitle) {
    // Set hidden input value
    document.getElementById('selectedTaskId').value = taskId;
    
    // Highlight selected task
    document.querySelectorAll('.task-item').forEach(item => {
        item.style.background = '';
    });
    document.querySelector(`.task-item[data-task-id="${taskId}"]`).style.background = '#fff3cd';
    
    // Show assign button and hide message
    document.getElementById('assignBtn').style.display = 'block';
    document.getElementById('selectTaskMsg').style.display = 'none';
    
    // Uncheck all members first (optional)
    document.querySelectorAll('input[name="member_ids[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

function updateTaskAction() {
    const taskId = document.getElementById('selectedTaskId').value;
    const checkedMembers = document.querySelectorAll('input[name="member_ids[]"]:checked');
    
    if (!taskId) {
        alert('Vui lòng chọn tác vụ');
        return false;
    }
    
    if (checkedMembers.length === 0) {
        alert('Vui lòng chọn ít nhất một thành viên');
        return false;
    }
    
    // Set form action dynamically
    const baseUrl = '<?php echo $baseUrl; ?>';
    document.getElementById('assignTaskForm').action = baseUrl + '/tasks/' + taskId + '/update-members';
    
    return true;
}

// Validate form before submit (optional - already done in updateTaskAction)
document.getElementById('assignTaskForm').addEventListener('submit', function(e) {
    return updateTaskAction();
});
</script>
