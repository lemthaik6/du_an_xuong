<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div class="card" style="margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; color: #2c3e50;">�️ Sản Phẩm</h1>
            <a href="<?php echo $baseUrl; ?>/contact" class="btn btn-success" style="padding: 10px 20px;">📧 Liên Hệ Để Mua</a>
        </div>
    </div>

    <!-- Search -->
    <div class="card" style="margin-bottom: 20px; background: #f8f9fa;">
        <form method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="flex: 1; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">🔍 Tìm</button>
            <a href="<?php echo $baseUrl; ?>/shop" class="btn btn-secondary" style="padding: 10px 20px;">Đặt lại</a>
        </form>
    </div>

    <!-- Products Grid -->
    <?php if (!empty($products)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            <?php foreach ($products as $product): ?>
                <div class="card" style="padding: 15px; text-align: center; transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: #ecf0f1; height: 200px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; overflow: hidden;">
                        <?php 
                            $imgSrc = '';
                            if (!empty($product['image'])) {
                                $imgSrc = $baseUrl . htmlspecialchars($product['image']);
                            } else {
                                $imgSrc = 'https://via.placeholder.com/250x200?text=' . urlencode(substr($product['name'], 0, 15));
                            }
                        ?>
                        <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/250x200?text=<?php echo urlencode(substr($product['name'], 0, 15)); ?>'">
                    </div>
                    
                    <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #2c3e50;">
                        <?php echo htmlspecialchars(substr($product['name'], 0, 50)); ?>
                    </h3>
                    
                    <p style="color: #666; font-size: 13px; margin: 10px 0;">
                        <?php echo htmlspecialchars(substr($product['description'], 0, 80)); ?>
                    </p>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin: 15px 0;">
                        <span style="font-size: 20px; font-weight: bold; color: #e74c3c;">
                            <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                        </span>
                        <span style="background: #27ae60; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px;">
                            Còn: <?php echo $product['stock']; ?>
                        </span>
                    </div>
                    
                    <div style="display: flex; gap: 8px;">
                        <a href="<?php echo $baseUrl; ?>/shop/<?php echo $product['id']; ?>" class="btn btn-primary" style="flex: 1; padding: 8px; font-size: 13px;">Xem chi tiết</a>
                        <a href="<?php echo $baseUrl; ?>/contact" class="btn btn-success" style="flex: 1; padding: 8px; font-size: 13px;">Liên hệ mua</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($pages > 1): ?>
            <div style="text-align: center; margin-top: 30px; display: flex; gap: 5px; justify-content: center;">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <a href="<?php echo $baseUrl; ?>/shop?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                       class="btn <?php echo $i == $current_page ? 'btn-primary' : 'btn-secondary'; ?>" 
                       style="padding: 8px 12px; font-size: 13px;">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="card" style="background: #f8f9fa; text-align: center; padding: 40px;">
            <h3>Không tìm thấy sản phẩm</h3>
            <p>Vui lòng thử tìm kiếm với từ khóa khác</p>
        </div>
    <?php endif; ?>
</div>

