<div style="max-width: 1300px; margin: 0 auto; padding: 30px 20px;">
    <!-- Header -->
    <div style="background: white; padding: 40px; border-radius: 15px; margin-bottom: 35px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 36px; font-weight: 700;">📦 Danh Sách Sản Phẩm</h1>
            <p style="margin: 8px 0 0 0; color: #95a5a6; font-size: 15px;">Khám phá bộ sưu tập sản phẩm của chúng tôi</p>
        </div>
        <a href="<?php echo $baseUrl; ?>/contact" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 14px 28px; border: none; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 15px; transition: all 0.3s; box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);">📧 Liên Hệ Để Mua</a>
    </div>

    <!-- Search -->
    <div style="background: white; padding: 25px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
        <form method="GET" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <input type="text" name="search" placeholder="🔍 Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="flex: 1; min-width: 200px; padding: 13px 16px; border: 2px solid #e1e8ed; border-radius: 10px; font-size: 14px; transition: all 0.3s; background: #f8f9fa;" onfocus="this.style.borderColor='#667eea'; this.style.background='white';" onblur="this.style.borderColor='#e1e8ed'; this.style.background='#f8f9fa';">
            <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 13px 30px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);">🔍 Tìm</button>
            <a href="<?php echo $baseUrl; ?>/shop" style="background: #e1e8ed; color: #2c3e50; padding: 13px 30px; border: none; border-radius: 10px; text-decoration: none; font-weight: 600; cursor: pointer; transition: all 0.3s;">↻ Đặt lại</a>
        </form>
    </div>

    <!-- Products Grid -->
    <?php if (!empty($products)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; margin-bottom: 40px;">
            <?php foreach ($products as $product): ?>
                <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 40px rgba(102, 126, 234, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0, 0, 0, 0.08)';">
                    <div style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); height: 240px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        <?php 
                            $imgSrc = '';
                            if (!empty($product['image'])) {
                                $imgSrc = $baseUrl . htmlspecialchars($product['image']);
                            } else {
                                $imgSrc = 'https://via.placeholder.com/250x200?text=' . urlencode(substr($product['name'], 0, 15));
                            }
                        ?>
                        <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.08)';" onmouseout="this.style.transform='scale(1)';" onerror="this.src='https://via.placeholder.com/250x200?text=<?php echo urlencode(substr($product['name'], 0, 15)); ?>'">
                    </div>
                    
                    <div style="padding: 22px;">
                        <h3 style="margin: 0 0 12px 0; font-size: 17px; color: #2c3e50; font-weight: 600; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h3>
                        
                        <p style="color: #7f8c8d; font-size: 13px; margin: 10px 0 12px 0; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin: 16px 0;">
                            <span style="font-size: 22px; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                <?php echo number_format($product['price'], 0, ',', '.'); ?> đ
                            </span>
                            <span style="background: linear-gradient(135deg, #27ae60 0%, #16a085 100%); color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600;">
                                Còn: <?php echo $product['stock']; ?>
                            </span>
                        </div>
                        
                        <div style="display: flex; gap: 10px; margin-top: 16px;">
                            <a href="<?php echo $baseUrl; ?>/shop/<?php echo $product['id']; ?>" style="flex: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 11px 0; text-align: center; text-decoration: none; border-radius: 8px; font-size: 13px; font-weight: 600; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.2)';">Xem chi tiết</a>
                            <a href="<?php echo $baseUrl; ?>/contact" style="flex: 1; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 11px 0; text-align: center; text-decoration: none; border-radius: 8px; font-size: 13px; font-weight: 600; transition: all 0.3s; box-shadow: 0 4px 12px rgba(79, 172, 254, 0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(79, 172, 254, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(79, 172, 254, 0.2)';">Liên hệ mua</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($pages > 1): ?>
            <div style="text-align: center; margin-top: 40px; display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <a href="<?php echo $baseUrl; ?>/shop?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                       style="padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; font-size: 14px; <?php echo $i == $current_page ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);' : 'background: white; color: #667eea; border: 2px solid #e1e8ed; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);'; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div style="background: white; text-align: center; padding: 60px 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
            <div style="font-size: 48px; margin-bottom: 15px;">📭</div>
            <h3 style="color: #2c3e50; font-size: 22px; margin: 0 0 10px 0;">Không tìm thấy sản phẩm</h3>
            <p style="color: #95a5a6; margin: 0; font-size: 15px;">Vui lòng thử tìm kiếm với từ khóa khác</p>
        </div>
    <?php endif; ?>
</div>
