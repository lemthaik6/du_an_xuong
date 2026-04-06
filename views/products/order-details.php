<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <a href="<?php echo $baseUrl; ?>/orders" style="color: #3498db; text-decoration: none; margin-bottom: 20px; display: inline-block;">← Quay lại danh sách đơn hàng</a>

    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; color: #2c3e50;">📦 Đơn Hàng #<?php echo $order['id']; ?></h1>
            <span style="background: #27ae60; color: white; padding: 8px 16px; border-radius: 4px; font-weight: bold;">
                <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?>
            </span>
        </div>
    </div>

    <!-- Order Information -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="card" style="padding: 20px;">
            <h3 style="margin-top: 0;">ℹ️ Thông Tin Đơn Hàng</h3>
            <p style="margin: 5px 0;"><strong>Mã Đơn:</strong> #<?php echo $order['id']; ?></p>
            <p style="margin: 5px 0;"><strong>Ngày Tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
            <p style="margin: 5px 0;"><strong>Trạng Thái:</strong> 
                <?php 
                    $statusText = [
                        'pending' => 'Chờ xử lý',
                        'processing' => 'Đang xử lý',
                        'shipped' => 'Đã gửi',
                        'delivered' => 'Đã giao',
                        'cancelled' => 'Hủy'
                    ];
                    $status = $order['status'] ?? 'pending';
                    echo $statusText[$status] ?? $status;
                ?>
            </p>
        </div>

        <div class="card" style="padding: 20px;">
            <h3 style="margin-top: 0;">📍 Địa Chỉ Giao Hàng</h3>
            <p style="margin: 0; line-height: 1.6;">
                <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?>
            </p>
        </div>
    </div>

    <!-- Items -->
    <div class="card" style="margin-bottom: 20px; padding: 20px;">
        <h3 style="margin-top: 0;">🛒 Chi Tiết Sản Phẩm</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #ecf0f1;">
                <tr>
                    <th style="padding: 12px; text-align: left;">Sản Phẩm</th>
                    <th style="padding: 12px; text-align: center;">Giá</th>
                    <th style="padding: 12px; text-align: center;">Số Lượng</th>
                    <th style="padding: 12px; text-align: right;">Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr style="border-bottom: 1px solid #ecf0f1;">
                        <td style="padding: 12px;">
                            <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <?php echo number_format($item['price'], 0, ',', '.'); ?> ₫
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <?php echo $item['quantity']; ?>
                        </td>
                        <td style="padding: 12px; text-align: right; font-weight: bold;">
                            <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> ₫
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="card" style="padding: 20px; background: #f8f9fa; text-align: right;">
        <h3 style="margin: 0; color: #e74c3c;">
            Tổng Tiền: <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> ₫
        </h3>
    </div>

    <!-- Notes -->
    <?php if (!empty($order['notes'])): ?>
        <div class="card" style="margin-top: 20px; padding: 20px;">
            <h3 style="margin-top: 0;">📝 Ghi Chú</h3>
            <p style="color: #666;">
                <?php echo nl2br(htmlspecialchars($order['notes'])); ?>
            </p>
        </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="<?php echo $baseUrl; ?>/orders" class="btn btn-primary" style="padding: 10px 20px;">← Quay Lại Danh Sách</a>
    </div>
</div>
