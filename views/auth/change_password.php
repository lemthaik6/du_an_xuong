<div style="max-width: 500px; margin: 30px auto;">
    <div class="card">
        <h2>Đổi Mật Khẩu</h2>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/profile/change-password">
            <div class="form-group">
                <label for="old_password">Mật Khẩu Cũ</label>
                <input type="password" id="old_password" name="old_password" required>
            </div>
            
            <div class="form-group">
                <label for="new_password">Mật Khẩu Mới</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Nhập Lại Mật Khẩu Mới</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success">💾 Đổi Mật Khẩu</button>
                <a href="<?php echo $baseUrl; ?>/profile" class="btn btn-primary">← Quay Lại</a>
            </div>
        </form>
    </div>
</div>
