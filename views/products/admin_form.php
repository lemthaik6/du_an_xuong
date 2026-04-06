<?php
$isEdit = !empty($product);
$title = $isEdit ? 'Sửa Sản Phẩm' : 'Tạo Sản Phẩm Mới';
$submitBtn = $isEdit ? 'Cập Nhật' : 'Tạo Mới';
$formAction = $isEdit ? $baseUrl . "/products/{$product['id']}/edit" : $baseUrl . "/products/create";
?>

<style>
    .form-card {
        max-width: 700px;
        margin: 0 auto;
    }

    .form-header {
        background: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        margin-bottom: 0;
        border-bottom: 2px solid #3498db;
    }

    .form-header h1 {
        font-size: 26px;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .form-header p {
        color: #7f8c8d;
        font-size: 14px;
    }

    .form-body {
        background: white;
        padding: 30px;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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

    .form-actions .btn {
        flex: 1;
    }

    .required {
        color: #e74c3c;
    }

    .help-text {
        font-size: 12px;
        color: #7f8c8d;
        margin-top: 5px;
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

    <div class="main-content form-card">
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
                <a href="<?php echo $baseUrl; ?>/products" class="btn btn-warning">Hủy</a>
                <button type="submit" class="btn btn-primary"><?php echo $submitBtn; ?></button>
            </div>
        </form>
    </div>
</div>
