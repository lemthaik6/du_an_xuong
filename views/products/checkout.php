<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <a href="<?php echo $baseUrl; ?>/cart" style="color: #3498db; text-decoration: none; margin-bottom: 20px; display: inline-block;">← Quay lại giỏ hàng</a>

    <div class="card" style="padding: 30px;">
        <h1 style="margin: 0 0 30px 0; color: #2c3e50; text-align: center;">💳 Thanh Toán</h1>

        <form method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                    👤 Họ và Tên <span style="color: #e74c3c;">*</span>
                </label>
                <input 
                    type="text" 
                    value="<?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?>"
                    readonly
                    style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; background: #f5f5f5;"
                />
            </div>

            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                    📧 Email <span style="color: #e74c3c;">*</span>
                </label>
                <input 
                    type="email" 
                    value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>"
                    readonly
                    style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; background: #f5f5f5;"
                />
            </div>

            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                    📍 Địa Chỉ Giao Hàng <span style="color: #e74c3c;">*</span>
                </label>
                <textarea 
                    name="shipping_address" 
                    placeholder="VD: 123 Đường ABC, Quận XYZ, TP Hồ Chí Minh"
                    rows="4"
                    style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif;"
                    required
                ></textarea>
            </div>

            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">
                    📝 Ghi Chú (Tùy Chọn)
                </label>
                <textarea 
                    name="notes" 
                    placeholder="Văn bản ghi chú..."
                    rows="3"
                    style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif;"
                ></textarea>
            </div>

            <div style="background: #f8f9fa; padding: 15px; border-radius: 4px;">
                <p style="margin: 0; color: #555;">
                    💡 <strong>Lưu ý:</strong> Vui lòng kiểm tra lại thông tin giao hàng trước khi xác nhận đơn hàng.
                </p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <button type="submit" class="btn btn-success" style="padding: 12px;">✓ Xác Nhận Đơn Hàng</button>
                <a href="<?php echo $baseUrl; ?>/cart" class="btn btn-secondary" style="padding: 12px; text-align: center; text-decoration: none;">← Quay Lại</a>
            </div>
        </form>
    </div>
</div>
