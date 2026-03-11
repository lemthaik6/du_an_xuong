<div style="max-width: 500px; margin: 30px auto;">
    <div class="card">
        <h2>Đăng Ký Tài Khoản</h2>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/register">
            <div class="form-group">
                <label for="username">Tên Đăng Nhập</label>
                <input type="text" id="username" name="username" required placeholder="Chọn tên đăng nhập">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Nhập địa chỉ email">
            </div>
            
            <div class="form-group">
                <label for="full_name">Họ và Tên</label>
                <input type="text" id="full_name" name="full_name" required placeholder="Nhập họ và tên đầy đủ">
            </div>
            
            <div class="form-group">
                <label for="phone">Số Điện Thoại</label>
                <input type="phone" id="phone" name="phone" placeholder="Nhập số điện thoại">
            </div>
            
            <div class="form-group">
                <label for="password">Mật Khẩu</label>
                <input type="password" id="password" name="password" required placeholder="Chọn mật khẩu an toàn">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Nhập Lại Mật Khẩu</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Nhập lại mật khẩu">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Đăng Ký</button>
            </div>
        </form>
        
        <p style="text-align: center; margin-top: 20px;">
            Đã có tài khoản? <a href="<?php echo $baseUrl; ?>/login">Đăng nhập ở đây</a>
        </p>
    </div>
</div>
