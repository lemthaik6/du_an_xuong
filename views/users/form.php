<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/users">👥 Người dùng</a>
    </div>
    
    <div class="main-content">
        <div class="card">
            <h2><?php echo isset($user) ? 'Chỉnh Sửa Người Dùng' : 'Tạo Người Dùng Mới'; ?></h2>
            
            <form method="POST" action="<?php echo isset($user) ? $baseUrl . '/users/' . $user['id'] . '/edit' : $baseUrl . '/users/create'; ?>">
                <div class="form-group">
                    <label for="username">Tên Đăng Nhập</label>
                    <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" <?php echo isset($user) ? 'readonly' : ''; ?>>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="full_name">Họ và Tên</label>
                    <input type="text" id="full_name" name="full_name" required value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="phone">Số Điện Thoại</label>
                    <input type="phone" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                </div>
                
                <?php if (!isset($user)): ?>
                    <div class="form-group">
                        <label for="password">Mật Khẩu</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="role">Vai Trò</label>
                    <select id="role" name="role" required>
                        <option value="user" <?php echo (isset($user) && $user['role'] == 'user') ? 'selected' : ''; ?>>Người dùng</option>
                        <option value="admin" <?php echo (isset($user) && $user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="active" <?php echo (isset($user) && $user['status'] == 'active') ? 'selected' : 'selected'; ?>>Hoạt động</option>
                        <option value="inactive" <?php echo (isset($user) && $user['status'] == 'inactive') ? 'selected' : ''; ?>>Vô hiệu</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">💾 Lưu</button>
                    <a href="<?php echo $baseUrl; ?>/users" class="btn btn-primary">← Quay Lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
