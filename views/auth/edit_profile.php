<div style="max-width: 500px; margin: 30px auto;">
    <div class="card">
        <h2>Chỉnh Sửa Hồ Sơ</h2>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/profile/edit">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            
            <div class="form-group">
                <label for="full_name">Họ và Tên</label>
                <input type="text" id="full_name" name="full_name" required value="<?php echo htmlspecialchars($user['full_name']); ?>">
            </div>
            
            <div class="form-group">
                <label for="phone">Số Điện Thoại</label>
                <input type="phone" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success">💾 Lưu Thay Đổi</button>
                <a href="<?php echo $baseUrl; ?>/profile" class="btn btn-primary">← Quay Lại</a>
            </div>
        </form>
    </div>
</div>
