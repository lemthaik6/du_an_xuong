<style>
    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .products-header h1 {
        font-size: 28px;
        color: #2c3e50;
        margin: 0;
    }

    .table-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
    }

    .products-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #ecf0f1;
    }

    .products-table th {
        padding: 15px;
        text-align: left;
        font-weight: bold;
        color: #2c3e50;
    }

    .products-table td {
        padding: 15px;
        border-bottom: 1px solid #ecf0f1;
    }

    .products-table tbody tr:hover {
        background: #f8f9fa;
    }

    .action-btns {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
    }

    .product-status {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: bold;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .product-price {
        color: #3498db;
        font-weight: bold;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
        padding: 20px;
    }

    .pagination a, .pagination span {
        padding: 8px 12px;
        border: 1px solid #bdc3c7;
        border-radius: 4px;
        text-decoration: none;
        color: #3498db;
        transition: all 0.3s;
    }

    .pagination a:hover {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }

    .pagination span.active {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #7f8c8d;
    }

    @media (max-width: 768px) {
        .products-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .products-table {
            font-size: 13px;
        }

        .products-table th, 
        .products-table td {
            padding: 10px;
        }

        .action-btns {
            flex-direction: column;
        }

        .btn-sm {
            width: 100%;
        }
    }
</style>

<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/users">👥 Quản lý Người dùng</a>
        <a href="<?php echo $baseUrl; ?>/categories">📑 Quản lý Danh mục</a>
        <a href="<?php echo $baseUrl; ?>/projects">📌 Quản lý Dự án</a>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Quản lý Tác vụ</a>
        <a href="<?php echo $baseUrl; ?>/teams">👨‍💼 Quản lý Đội nhóm</a>
        <a href="<?php echo $baseUrl; ?>/products">📦 Quản lý Sản Phẩm</a>
        <a href="<?php echo $baseUrl; ?>/profile">⚙️ Hồ sơ của tôi</a>
    </div>

    <div class="main-content">
        <div class="products-header">
            <h1>📦 Quản Lý Sản Phẩm</h1>
            <a href="<?php echo $baseUrl; ?>/products/create" class="btn btn-primary">➕ Thêm Sản Phẩm</a>
        </div>

        <!-- Products Table -->
        <div class="table-container">
            <?php if (!empty($products) && is_array($products)): ?>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 100px;">Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                        <th style="width: 120px;">Giá</th>
                        <th style="width: 80px;">Stock</th>
                        <th style="width: 100px;">Danh Mục</th>
                        <th style="width: 90px;">Trạng Thái</th>
                        <th style="width: 150px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td>
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?php echo $baseUrl; ?><?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/80x80?text=<?php echo urlencode(substr($product['name'], 0, 10)); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                                <small style="color: #7f8c8d;">
                                    <?php echo htmlspecialchars(substr($product['description'] ?? '', 0, 50)); ?>...
                                </small>
                            </td>
                            <td class="product-price">
                                <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ
                            </td>
                            <td><?php echo $product['stock']; ?></td>
                            <td><?php echo htmlspecialchars($product['category'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="product-status <?php echo $product['status'] === 'active' ? 'status-active' : 'status-inactive'; ?>">
                                    <?php echo $product['status'] === 'active' ? '✅ Hoạt động' : '❌ Dừng'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?php echo $baseUrl; ?>/products/<?php echo $product['id']; ?>/edit" class="btn btn-warning btn-sm">
                                        ✏️ Sửa
                                    </a>
                                    <a href="<?php echo $baseUrl; ?>/products/<?php echo $product['id']; ?>/delete" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">
                                        🗑️ Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($pages > 1): ?>
                <div class="pagination">
                    <?php
                    for ($p = 1; $p <= $pages; $p++) {
                        if ($p == $current_page) {
                            echo '<span class="active">' . $p . '</span>';
                        } else {
                            echo '<a href="' . $baseUrl . '/products?page=' . $p . '">' . $p . '</a>';
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <p>Không có sản phẩm nào. <a href="<?php echo $baseUrl; ?>/products/create">Tạo sản phẩm đầu tiên</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
