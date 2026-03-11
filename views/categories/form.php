<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/categories">📑 Danh mục</a>
    </div>
    
    <div class="main-content">
        <div class="card">
            <h2><?php echo isset($category) ? 'Chỉnh Sửa Danh Mục' : 'Tạo Danh Mục Mới'; ?></h2>
            
            <form method="POST" action="<?php echo isset($category) ? $baseUrl . '/categories/' . $category['id'] . '/edit' : $baseUrl . '/categories/create'; ?>">
                <div class="form-group">
                    <label for="name">Tên Danh Mục</label>
                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($category['name'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="icon">Biểu Tượng</label>
                    <input type="text" id="icon" name="icon" value="<?php echo htmlspecialchars($category['icon'] ?? ''); ?>" placeholder="Ví dụ: 📊">
                </div>
                
                <div class="form-group">
                    <label for="color">Màu Sắc</label>
                    <input type="color" id="color" name="color" value="<?php echo htmlspecialchars($category['color'] ?? '#3498db'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select id="status" name="status">
                        <option value="active" <?php echo (isset($category) && $category['status'] == 'active') ? 'selected' : 'selected'; ?>>Hoạt động</option>
                        <option value="inactive" <?php echo (isset($category) && $category['status'] == 'inactive') ? 'selected' : ''; ?>>Vô hiệu</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">💾 Lưu</button>
                    <a href="<?php echo $baseUrl; ?>/categories" class="btn btn-primary">← Quay Lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
