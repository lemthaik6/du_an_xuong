<div style="max-width: 400px; margin: 50px auto;">
    <div class="card">
        <h2>Đăng Nhập</h2>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Nhập email của bạn">
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Đăng Nhập</button>
            </div>
        </form>
        
        <p style="text-align: center; margin-top: 20px;">
            Chưa có tài khoản? <a href="<?php echo $baseUrl; ?>/register">Đăng ký ở đây</a>
        </p>
    </div>
</div>
