<div style="max-width: 960px; margin: 0 auto; padding: 20px;">
    <div style="background: #ffffff; border-radius: 24px; padding: 30px; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08); border: 1px solid rgba(148, 163, 184, 0.18);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 28px;">
            <div>
                <h1 style="margin: 0 0 8px 0; font-size: 32px; color: #111827;">👤 Hồ Sơ Khách Hàng</h1>
                <p style="margin: 0; color: #475569; font-size: 15px;">Thông tin cá nhân của bạn trong hệ thống.</p>
            </div>
            <a href="<?php echo $baseUrl; ?>/dashboard" style="display: inline-flex; align-items: center; justify-content: center; background: #4f46e5; color: white; padding: 12px 24px; border-radius: 999px; text-decoration: none; font-weight: 700;">← Về Dashboard</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 24px;">
            <div style="background: #f8fafc; padding: 22px; border-radius: 18px; border-left: 4px solid #667eea;">
                <p style="margin: 0 0 10px 0; color: #4b5563; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Tên đăng nhập</p>
                <p style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;"><?php echo htmlspecialchars($user['username'] ?? '-'); ?></p>
            </div>
            <div style="background: #f8fafc; padding: 22px; border-radius: 18px; border-left: 4px solid #4f46e5;">
                <p style="margin: 0 0 10px 0; color: #4b5563; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Email</p>
                <p style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;"><?php echo htmlspecialchars($user['email'] ?? '-'); ?></p>
            </div>
            <div style="background: #f8fafc; padding: 22px; border-radius: 18px; border-left: 4px solid #10b981;">
                <p style="margin: 0 0 10px 0; color: #4b5563; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Họ và tên</p>
                <p style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;"><?php echo htmlspecialchars($user['full_name'] ?? '-'); ?></p>
            </div>
            <div style="background: #f8fafc; padding: 22px; border-radius: 18px; border-left: 4px solid #f97316;">
                <p style="margin: 0 0 10px 0; color: #4b5563; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Số điện thoại</p>
                <p style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;"><?php echo htmlspecialchars($user['phone'] ?? 'Chưa cập nhật'); ?></p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 16px;">
            <div style="background: #ffffff; padding: 22px; border-radius: 18px; border: 1px solid rgba(148, 163, 184, 0.18);">
                <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Vai trò</p>
                <p style="margin: 0; font-size: 16px; font-weight: 700; color: #111827;"><?php echo htmlspecialchars($user['role'] ?? '-'); ?></p>
            </div>
            <div style="background: #ffffff; padding: 22px; border-radius: 18px; border: 1px solid rgba(148, 163, 184, 0.18);">
                <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Trạng thái</p>
                <p style="margin: 0; font-size: 16px; font-weight: 700; color: #111827;"><span style="display: inline-flex; align-items: center; justify-content: center; background: <?php echo ($user['status'] ?? '') === 'active' ? '#10b981' : '#ef4444'; ?>; color: white; padding: 8px 14px; border-radius: 999px;"><?php echo ($user['status'] ?? '') === 'active' ? 'Hoạt động' : 'Bị khóa'; ?></span></p>
            </div>
        </div>
    </div>
</div>

