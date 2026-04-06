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

        <form method="POST" action="<?php echo $formAction; ?>" class="form-body" enctype="multipart/form-data">
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

            <div class="form-group">
                <label for="image">Hình Ảnh Sản Phẩm</label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/*"
                    onchange="previewImage(event)"
                >
                <p class="help-text">Chọn file ảnh (JPG, PNG, GIF) - Tối đa 5MB</p>
                
                <?php if (!empty($product) && !empty($product['image'])): ?>
                    <div style="margin-top: 15px;">
                        <p style="margin-bottom: 8px; font-weight: bold;">Ảnh hiện tại:</p>
                        <img id="currentImage" src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="max-width: 200px; border-radius: 6px; border: 1px solid #ddd;">
                    </div>
                <?php endif; ?>
                
                <div id="imagePreview" style="margin-top: 15px; display: none;">
                    <p style="margin-bottom: 8px; font-weight: bold;">Xem trước:</p>
                    <img id="preview" style="max-width: 200px; border-radius: 6px; border: 1px solid #ddd;">
                </div>
            </div>

            <script>
                function previewImage(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('preview');
                    const previewDiv = document.getElementById('imagePreview');
                    const currentImage = document.getElementById('currentImage');
                    
                    if (file) {
                        // Validate file size (5MB max)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Kích thước file tối đa là 5MB');
                            event.target.value = '';
                            return;
                        }
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            previewDiv.style.display = 'block';
                            if (currentImage) {
                                currentImage.style.display = 'none';
                            }
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewDiv.style.display = 'none';
                        if (currentImage) {
                            currentImage.style.display = 'block';
                        }
                    }
                }
            </script>

            <div class="form-actions">
                <a href="<?php echo $baseUrl; ?>/products" class="btn btn-warning">Hủy</a>
                <button type="submit" class="btn btn-primary"><?php echo $submitBtn; ?></button>
            </div>
        </form>
    </div>
</div>
