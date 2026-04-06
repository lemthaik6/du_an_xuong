<?php
// Kiểm tra admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /du_an_xuong/public/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 28px;
            color: #333;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-danger {
            background: #f44336;
            color: white;
        }

        .btn-danger:hover {
            background: #da190b;
        }

        .btn-warning {
            background: #ff9800;
            color: white;
        }

        .btn-warning:hover {
            background: #e68900;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
            border-bottom: 2px solid #ddd;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: bold;
            color: #333;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #f9f9f9;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }

        .status {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 13px;
            font-weight: bold;
        }

        .status.active {
            background: #d4edda;
            color: #155724;
        }

        .status.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .price {
            color: #667eea;
            font-weight: bold;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #999;
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
            border: 1px solid #ddd;
            border-radius: 3px;
            text-decoration: none;
            color: #667eea;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
        }

        .pagination span.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            table {
                font-size: 13px;
            }

            th, td {
                padding: 10px;
            }

            .action-btns {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Quản Lý Sản Phẩm</h1>
            <a href="/du_an_xuong/public/products/create" class="btn btn-primary">➕ Thêm Sản Phẩm</a>
        </div>

        <!-- Alerts -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">✅ Thao tác thành công!</div>
        <?php endif; ?>

        <!-- Products Table -->
        <div class="table-container">
            <?php if (!empty($products) && is_array($products)): ?>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
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
                                    <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                                    <small style="color: #999;">
                                        <?php echo htmlspecialchars(substr($product['description'] ?? '', 0, 50)); ?>...
                                    </small>
                                </td>
                                <td class="price">
                                    <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ
                                </td>
                                <td><?php echo $product['stock']; ?></td>
                                <td><?php echo htmlspecialchars($product['category'] ?? 'N/A'); ?></td>
                                <td>
                                    <span class="status <?php echo $product['status']; ?>">
                                        <?php echo $product['status'] === 'active' ? '✅ Hoạt động' : '❌ Dừng'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="/du_an_xuong/public/products/<?php echo $product['id']; ?>/edit" class="btn btn-warning btn-sm">
                                            ✏️ Sửa
                                        </a>
                                        <a href="/du_an_xuong/public/products/<?php echo $product['id']; ?>/delete" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">
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
                                echo '<a href="/du_an_xuong/public/products?page=' . $p . '">' . $p . '</a>';
                            }
                        }
                        ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty">
                    <p>📭 Chưa có sản phẩm. <a href="/du_an_xuong/public/products/create">Tạo sản phẩm mới</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
