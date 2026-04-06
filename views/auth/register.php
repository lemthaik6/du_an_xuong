<div class="auth-header">
    <div class="logo">✍️</div>
    <h1>Đăng Ký Tài Khoản</h1>
    <p>Tạo tài khoản mới để bắt đầu</p>
</div>

<form method="POST" action="<?php echo $baseUrl; ?>/register">
    <div class="form-group">
        <label for="username">Tên Đăng Nhập</label>
        <input type="text" id="username" name="username" required placeholder="Chọn tên đăng nhập" autofocus>
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required placeholder="your@email.com">
    </div>
    
    <div class="form-group">
        <label for="full_name">Họ và Tên</label>
        <input type="text" id="full_name" name="full_name" required placeholder="Nhập họ và tên đầy đủ">
    </div>
    
    <div class="form-group">
        <label for="phone">Số Điện Thoại</label>
        <input type="phone" id="phone" name="phone" placeholder="0123456789">
    </div>

    <div class="form-group">
        <label for="role">Loại Tài Khoản</label>
        <select id="role" name="role" required>
            <option value="">-- Chọn loại tài khoản --</option>
            <option value="user">👤 Nhân Viên (User)</option>
            <option value="customer">🛍️ Khách Hàng (Customer)</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="password">Mật Khẩu</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">
    </div>
    
    <div class="form-group">
        <label for="confirm_password">Xác Nhận Mật Khẩu</label>
        <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••">
    </div>
    
    <button type="submit" class="btn btn-primary">Đăng Ký</button>
</form>

<div class="auth-footer">
    <p>Đã có tài khoản? <a href="<?php echo $baseUrl; ?>/login">Đăng nhập ở đây</a></p>
</div>
