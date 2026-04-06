<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #2c3e50; margin-bottom: 30px;">📦 Đơn Hàng Của Tôi</h1>

    <?php if (!empty($orders)): ?>
        <div class="card">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #34495e; color: white;">
                    <tr>
                        <th style="padding: 15px; text-align: left;">Mã Đơn Hàng</th>
                        <th style="padding: 15px; text-align: center;">Ngày Tạo</th>
                        <th style="padding: 15px; text-align: right;">Tổng Tiền</th>
                        <th style="padding: 15px; text-align: center;">Trạng Thái</th>
                        <th style="padding: 15px; text-align: center;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr style="border-bottom: 1px solid #ecf0f1;">
                            <td style="padding: 15px;">
                                <strong>#<?php echo $order['id']; ?></strong>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?>
                            </td>
                            <td style="padding: 15px; text-align: right; font-weight: bold; color: #e74c3c;">
                                <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> ₫
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <?php 
                                    $statusColor = [
                                        'pending' => '#f39c12',
                                        'processing' => '#3498db',
                                        'shipped' => '#9b59b6',
                                        'delivered' => '#27ae60',
                                        'cancelled' => '#e74c3c'
                                    ];
                                    $statusText = [
                                        'pending' => 'Chờ xử lý',
                                        'processing' => 'Đang xử lý',
                                        'shipped' => 'Đã gửi',
                                        'delivered' => 'Đã giao',
                                        'cancelled' => 'Hủy'
                                    ];
                                    $status = $order['status'] ?? 'pending';
                                ?>
                                <span style="background: <?php echo $statusColor[$status] ?? '#95a5a6'; ?>; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px;">
                                    <?php echo $statusText[$status] ?? $status; ?>
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="<?php echo $baseUrl; ?>/orders/<?php echo $order['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem Chi Tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="card" style="background: #f8f9fa; text-align: center; padding: 40px;">
            <p style="font-size: 40px; margin: 0;">📦</p>
            <h2>Chưa có đơn hàng nào</h2>
            <p>Bạn chưa tạo đơn hàng nào</p>
            <a href="<?php echo $baseUrl; ?>/shop" class="btn btn-primary" style="padding: 10px 20px; display: inline-block; margin-top: 10px;">
                Bắt đầu mua sắm
            </a>
        </div>
    <?php endif; ?>
</div>
