<div class="auth-header">
    <div class="logo">🔐</div>
    <h1>Đăng Nhập</h1>
    <p>Nhập thông tin để tiếp tục</p>
</div>

<form method="POST" action="<?php echo $baseUrl; ?>/login">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required placeholder="your@email.com" autofocus>
    </div>
    
    <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">
    </div>
    
    <button type="submit" class="btn btn-primary">Đăng Nhập</button>
</form>

<div class="auth-footer">
    <p>Chưa có tài khoản? <a href="<?php echo $baseUrl; ?>/register">Đăng ký ngay</a></p>
</div>
