<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <a href="<?php echo $baseUrl; ?>/shop" style="color: #3498db; text-decoration: none; margin-bottom: 20px; display: inline-block;">← Quay lại sản phẩm</a>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- Image -->
        <div class="card" style="padding: 20px;">
            <div style="background: #ecf0f1; height: 400px; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <div style="font-size: 80px;">📦</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Details -->
        <div class="card" style="padding: 20px;">
            <h1 style="margin: 0 0 15px 0; color: #2c3e50;">
                <?php echo htmlspecialchars($product['name']); ?>
            </h1>

            <div style="margin-bottom: 20px;">
                <span style="display: block; font-size: 28px; font-weight: bold; color: #e74c3c; margin-bottom: 10px;">
                    <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                </span>
                <span style="background: <?php echo $product['stock'] > 0 ? '#27ae60' : '#e74c3c'; ?>; color: white; padding: 8px 16px; border-radius: 4px;">
                    <?php echo $product['stock'] > 0 ? 'Còn hàng (' . $product['stock'] . ')' : 'Hết hàng'; ?>
                </span>
            </div>

            <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #ecf0f1;">
                <h3 style="margin-top: 0;">Mô Tả</h3>
                <p style="color: #555; line-height: 1.6;">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </p>
            </div>

            <div style="margin-bottom: 20px;">
                <h3 style="margin-top: 0; margin-bottom: 10px;">Danh Mục</h3>
                <span style="background: #3498db; color: white; padding: 6px 12px; border-radius: 4px; display: inline-block;">
                    <?php echo htmlspecialchars($product['category']); ?>
                </span>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="<?php echo $baseUrl; ?>/contact" class="btn btn-success" style="flex: 1; padding: 12px;">📧 Liên Hệ Để Mua</a>
                <a href="<?php echo $baseUrl; ?>/shop" class="btn btn-secondary" style="flex: 1; padding: 12px;">← Quay Lại</a>
            </div>
        </div>
    </div>
</div>

