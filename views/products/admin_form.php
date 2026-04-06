<?php
// Kiểm tra admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /du_an_xuong/public/login');
    exit;
}

$isEdit = !empty($product);
$title = $isEdit ? 'Sửa Sản Phẩm' : 'Tạo Sản Phẩm Mới';
$submitBtn = $isEdit ? 'Cập Nhật' : 'Tạo Mới';
$formAction = $isEdit ? "/du_an_xuong/public/products/{$product['id']}/edit" : "/du_an_xuong/public/products/create";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .form-header {
            background: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0;
        }

        .form-header h1 {
            font-size: 26px;
            margin-bottom: 5px;
        }

        .form-header p {
            color: #999;
            font-size: 14px;
        }

        .form-body {
            background: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .required {
            color: #f44336;
        }

        .help-text {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }

        .back-link {
            color: white;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/du_an_xuong/public/products" class="back-link">← Quay Lại</a>

        <div class="form-header">
            <h1><?php echo $title; ?></h1>
            <p>Quản lý thông tin sản phẩm</p>
        </div>

        <form method="POST" action="<?php echo $formAction; ?>" class="form-body">
            <div class="form-group">
                <label for="name">Tên Sản Phẩm <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" 
                    required
                    placeholder="Ví dụ: Sản phẩm A"
                >
            </div>

            <div class="form-group">
                <label for="description">Mô Tả <span class="required">*</span></label>
                <textarea 
                    id="description" 
                    name="description" 
                    required
                    placeholder="Mô tả chi tiết sản phẩm..."
                ><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Giá (VNĐ) <span class="required">*</span></label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" 
                        required
                        min="0"
                        step="1000"
                        placeholder="0"
                    >
                </div>

                <div class="form-group">
                    <label for="stock">Số Lượng <span class="required">*</span></label>
                    <input 
                        type="number" 
                        id="stock" 
                        name="stock" 
                        value="<?php echo htmlspecialchars($product['stock'] ?? 0); ?>" 
                        required
                        min="0"
                        placeholder="0"
                    >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category">Danh Mục</label>
                    <input 
                        type="text" 
                        id="category" 
                        name="category" 
                        value="<?php echo htmlspecialchars($product['category'] ?? ''); ?>" 
                        placeholder="Ví dụ: Điện tử, Quần áo..."
                    >
                </div>

                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="active" <?php echo (isset($product) && $product['status'] === 'active') ? 'selected' : ''; ?>>
                            ✅ Hoạt động
                        </option>
                        <option value="inactive" <?php echo (isset($product) && $product['status'] === 'inactive') ? 'selected' : ''; ?>>
                            ❌ Dừng
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="/du_an_xuong/public/products" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary"><?php echo $submitBtn; ?></button>
            </div>
        </form>
    </div>
</body>
</html>
