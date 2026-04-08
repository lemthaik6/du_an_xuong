<div class="product-detail-page">
    <style>
        .product-detail-page {
            max-width: 1080px;
            margin: 0 auto;
            padding: 24px 18px 40px;
            color: #1f2937;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .product-detail-page a.back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 700;
            margin-bottom: 24px;
            transition: all 0.25s ease;
        }

        .product-detail-page a.back-link:hover {
            color: #2563eb;
            transform: translateX(-2px);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 32px;
        }

        .detail-card {
            background: #ffffff;
            border-radius: 28px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .detail-image {
            background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%);
            min-height: 460px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .detail-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .detail-card:hover .detail-image img {
            transform: scale(1.03);
        }

        .detail-body {
            padding: 32px;
        }

        .detail-title {
            margin: 0 0 18px;
            font-size: 32px;
            line-height: 1.1;
            color: #0f172a;
            font-weight: 800;
        }

        .detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 26px;
        }

        .detail-price {
            font-size: 32px;
            font-weight: 800;
            color: #2563eb;
        }

        .detail-stock {
            display: inline-flex;
            align-items: center;
            padding: 10px 16px;
            border-radius: 999px;
            color: white;
            font-weight: 700;
            font-size: 14px;
            background: #16a34a;
        }

        .detail-stock.out {
            background: #dc2626;
        }

        .detail-section {
            margin-bottom: 26px;
            padding-bottom: 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-section h3 {
            margin: 0 0 14px;
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .detail-section p {
            color: #475569;
            line-height: 1.75;
            font-size: 15px;
            white-space: pre-line;
        }

        .category-pill {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 999px;
            background: #e0f2fe;
            color: #0c4a6e;
            font-weight: 700;
            font-size: 14px;
        }

        .detail-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .detail-actions a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 14px 18px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-buy {
            background: #14b8a6;
            color: white;
            box-shadow: 0 14px 30px rgba(20, 184, 166, 0.18);
        }

        .btn-buy:hover {
            background: #0f766e;
            transform: translateY(-2px);
        }

        .btn-back {
            background: #3b82f6;
            color: white;
            box-shadow: 0 14px 30px rgba(59, 130, 246, 0.18);
        }

        .btn-back:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        @media (max-width: 960px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 620px) {
            .detail-body {
                padding: 24px;
            }

            .detail-meta {
                flex-direction: column;
                align-items: flex-start;
            }

            .detail-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <a href="<?php echo $baseUrl; ?>/dashboard" class="back-link">← Về Dashboard</a>

    <div class="detail-grid">
        <div class="detail-card">
            <div class="detail-image">
                <?php 
                    $imgSrc = '';
                    if (!empty($product['image'])) {
                        $imgSrc = $baseUrl . htmlspecialchars($product['image']);
                    } else {
                        $imgSrc = 'https://via.placeholder.com/700x700?text=' . urlencode($product['name']);
                    }
                ?>
                <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" onerror="this.src='https://via.placeholder.com/700x700?text=<?php echo urlencode($product['name']); ?>'">
            </div>
        </div>

        <div class="detail-card detail-body">
            <h1 class="detail-title"><?php echo htmlspecialchars($product['name']); ?></h1>

            <div class="detail-meta">
                <div class="detail-price"><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</div>
                <div class="detail-stock <?php echo $product['stock'] > 0 ? '' : 'out'; ?>">
                    <?php echo $product['stock'] > 0 ? 'Còn hàng (' . $product['stock'] . ')' : 'Hết hàng'; ?>
                </div>
            </div>

            <div class="detail-section">
                <h3>Mô Tả</h3>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>

            <div class="detail-section">
                <h3>Danh Mục</h3>
                <span class="category-pill"><?php echo htmlspecialchars($product['category']); ?></span>
            </div>

            <div class="detail-actions">
                <a href="<?php echo $baseUrl; ?>/contact?product_id=<?php echo urlencode($product['id']); ?>" class="btn-buy">📧 Liên Hệ Để Mua</a>
                <a href="<?php echo $baseUrl; ?>/dashboard" class="btn-back">← Quay Lại Dashboard</a>
            </div>
        </div>
    </div>
</div>

