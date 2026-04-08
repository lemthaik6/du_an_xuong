<div style="max-width: 1100px; margin: 0 auto; padding: 30px 20px;">
    <!-- Back Button -->
    <a href="<?php echo $baseUrl; ?>/shop" style="color: #667eea; text-decoration: none; margin-bottom: 30px; display: inline-block; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.color='#764ba2';" onmouseout="this.style.color='#667eea';">← Quay lại danh sách sản phẩm</a>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;">
        <!-- Image Section -->
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
            <div style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); height: 450px; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                <?php 
                    $imgSrc = '';
                    if (!empty($product['image'])) {
                        $imgSrc = $baseUrl . htmlspecialchars($product['image']);
                    } else {
                        $imgSrc = 'https://via.placeholder.com/400x400?text=' . urlencode($product['name']);
                    }
                ?>
                <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';" onerror="this.src='https://via.placeholder.com/400x400?text=<?php echo urlencode($product['name']); ?>'">
            </div>
        </div>

        <!-- Details Section -->
        <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
            <h1 style="margin: 0 0 20px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 32px; font-weight: 700;">
                <?php echo htmlspecialchars($product['name']); ?>
            </h1>

            <!-- Price & Stock Status -->
            <div style="margin-bottom: 25px; padding-bottom: 25px; border-bottom: 2px solid #e1e8ed;">
                <div style="display: flex; align-items: baseline; gap: 20px; margin-bottom: 15px;">
                    <span style="font-size: 32px; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <?php echo number_format($product['price'], 0, ',', '.'); ?> đ
                    </span>
                </div>
                <span style="display: inline-block; background: linear-gradient(135deg, <?php echo $product['stock'] > 0 ? '#27ae60 0%, #16a085' : '#e74c3c 0%, #c0392b'; ?> 100%); color: white; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                    <?php echo $product['stock'] > 0 ? '✓ Còn hàng (' . $product['stock'] . ' cái)' : '✕ Hết hàng'; ?>
                </span>
            </div>

            <!-- Category -->
            <div style="margin-bottom: 25px; padding-bottom: 25px; border-bottom: 2px solid #e1e8ed;">
                <h3 style="margin: 0 0 12px 0; color: #2c3e50; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #95a5a6;">Danh Mục</h3>
                <span style="display: inline-block; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                    <?php echo htmlspecialchars($product['category']); ?>
                </span>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 30px; padding-bottom: 25px; border-bottom: 2px solid #e1e8ed;">
                <h3 style="margin: 0 0 12px 0; color: #2c3e50; font-weight: 600; font-size: 16px;">Mô Tả Sản Phẩm</h3>
                <p style="color: #555; line-height: 1.8; margin: 0; font-size: 15px;">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </p>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; flex-direction: column;">
                <a href="<?php echo $baseUrl; ?>/contact" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 16px 24px; text-align: center; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 15px; transition: all 0.3s; box-shadow: 0 5px 15px rgba(245, 87, 108, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 30px rgba(245, 87, 108, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 15px rgba(245, 87, 108, 0.3)';">📧 Liên Hệ Để Mua</a>
                <a href="<?php echo $baseUrl; ?>/shop" style="background: white; color: #667eea; padding: 16px 24px; text-align: center; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 15px; border: 2px solid #667eea; transition: all 0.3s; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);" onmouseover="this.style.background='#667eea'; this.style.color='white'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(102, 126, 234, 0.3)';" onmouseout="this.style.background='white'; this.style.color='#667eea'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(0, 0, 0, 0.06)';">← Quay Lại</a>
            </div>
        </div>
    </div>

    <!-- Additional Info section (Optional) -->
    <div style="margin-top: 40px; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
        <h3 style="margin-top: 0; color: #2c3e50; font-size: 20px; font-weight: 700; margin-bottom: 20px;">Thông Tin Chi Tiết</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div style="padding: 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-radius: 10px;">
                <p style="margin: 0 0 8px 0; color: #95a5a6; font-size: 12px; font-weight: 600; text-transform: uppercase;">Giá</p>
                <p style="margin: 0; color: #2c3e50; font-size: 18px; font-weight: 700;"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</p>
            </div>
            <div style="padding: 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-radius: 10px;">
                <p style="margin: 0 0 8px 0; color: #95a5a6; font-size: 12px; font-weight: 600; text-transform: uppercase;">Tồn Kho</p>
                <p style="margin: 0; color: #2c3e50; font-size: 18px; font-weight: 700;"><?php echo $product['stock']; ?> cái</p>
            </div>
            <div style="padding: 20px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-radius: 10px;">
                <p style="margin: 0 0 8px 0; color: #95a5a6; font-size: 12px; font-weight: 600; text-transform: uppercase;">Danh Mục</p>
                <p style="margin: 0; color: #2c3e50; font-size: 18px; font-weight: 700;"><?php echo htmlspecialchars($product['category']); ?></p>
            </div>
        </div>
    </div>
</div>
