# HƯỚNG DẪN TEST CUSTOMER FEATURE - 3 SCENARIO

## ✅ SETUP ĐÃ HOÀN THÀNH

Các thay đổi đã được triển khai:
1. ✅ Cập nhật DashboardController - thêm `customerDashboard()` method
2. ✅ Tạo giao diện dashboard/customer.php - UI đẹp cho khách hàng
3. ✅ Cập nhật ContactController - xử lý form liên hệ
4. ✅ Cập nhật Auth.php - hỗ trợ role 'customer'
5. ✅ Cập nhật register.php - thêm lựa chọn loại tài khoản
6. ✅ Cập nhật routes/web.php - thêm /contact/send route

---

## 🚀 TEST SCENARIO 1: Đăng Ký Tài Khoản Customer

### Bước 1: Truy cập form đăng ký
```
URL: http://localhost/du_an_xuong/public/register
```

### Bước 2: Điền form như sau
```
- Tên Đăng Nhập: customer_demo
- Email: customer@demo.com
- Họ và Tên: Khách Hàng Demo
- Số Điện Thoại: 0909123456
- Loại Tài Khoản: 🛍️ Khách Hàng (Customer)  ← CHỌN CÁI NÀY!
- Mật Khẩu: 123456
- Nhập Lại Mật Khẩu: 123456
```

### Bước 3: Nhấn "Đăng Ký"
✅ KỲ VỌNG: Thông báo "Đăng ký thành công, vui lòng đăng nhập"

### Bước 4: Đăng nhập
```
URL: http://localhost/du_an_xuong/public/login
Email: customer@demo.com
Password: 123456
```

✅ KỲ VỌNG: Đăng nhập thành công → Chuyển đến dashboard

---

## 📦 TEST SCENARIO 2: Xem Sản Phẩm (Chỉ Xem, Không Mua)

### Sau khi đăng nhập (từ scenario 1)

✅ GIAO DIỆN CUSTOMER DASHBOARD SẼ HIỂN THỊ:

1. **Header**
   - Chào Mừng
   - Tên user: "Khách Hàng Demo"
   - Nút "Cài Đặt Tài Khoản"
   - Nút "Đăng Xuất"

2. **Navigation**
   - 📦 Xem Sản Phẩm
   - 📞 Liên Hệ Admin
   - 👤 Hồ Sơ Cá Nhân

3. **Welcome Section**
   - Mô tả về role khách hàng
   - 3 feature boxes:
     * 📦 Xem Sản Phẩm
     * 💬 Liên Hệ Admin
     * 👤 Quản Lý Tài Khoản

4. **Danh Sách Sản Phẩm**
   - Hiển thị ~8 sản phẩm mới nhất
   - Mỗi sản phẩm có:
     * Hình ảnh
     * Tên sản phẩm
     * Mô tả (80 ký tự đầu)
     * Giá (format VNĐ)
     * ⭐ QUAN TRỌNG: Nút "💬 Liên Hệ Để Mua" (KHÔNG CÓ NÚT MUA TRỰC TIẾP)

### ✅ TEST: Kiểm tra các sản phẩm
- [ ] Sản phẩm hiển thị đúng
- [ ] Giá hiển thị đúng định dạng VNĐ
- [ ] Nút "Liên Hệ Để Mua" = "💬"
- [ ] KHÔNG CÓ nút "Thêm Vào Giỏ", "Mua Ngay" hay tương tự

---

## 📞 TEST SCENARIO 3: Liên Hệ Admin Để Mua

### Vẫn ở dashboard customer (từ scenario 2)

### Scroll xuống → Tìm phần "📞 Liên Hệ Admin Để Mua"

### Form liên hệ sẽ tự động điền:
```
- Tên: Khách Hàng Demo (tự động từ session)
- Email: customer@demo.com (tự động từ session)
```

### Điền thêm:
```
- Chủ Đề: Muốn mua Sản Phẩm 1
- Nội Dung Tin Nhắn: 
  Xin chào Admin!
  Tôi quan tâm đến sản phẩm "Sản Phẩm 1".
  Vui lòng liên hệ để báo giá.
  Cảm ơn!
```

### Nhấn "Gửi Tin Nhắn"

✅ KỲ VỌNG KẾT QUẢ:
```
- Thông báo xanh: "✅ Tin nhắn của bạn đã được gửi thành công! Admin sẽ liên hệ với bạn sớm."
- Ở lại trang dashboard
- Form reset
```

### ✅ KIỂM TRA:
- [ ] Form submit thành công
- [ ] Hiển thị thông báo xanh
- [ ] Không chuyển trang hay đơ máy
- [ ] Tin nhắn được lưu (có thể check database table)

---

## 🎯 KIỂM TRA TOÀN BỘ FLOW

Sau 3 scenario, hãy kiểm tra:

### ✅ Giao Diện
- [ ] Customer dashboard khác hẳn user dashboard
- [ ] Không có menu quản lý (Projects, Tasks, Users, Teams, etc.)
- [ ] Chỉ có: View Products + Contact Form
- [ ] Giao diện sạch, chuyên nghiệp

### ✅ Chức Năng
- [ ] Đăng ký customer ✅
- [ ] Đăng nhập customer ✅
- [ ] Xem sản phẩm (chỉ xem, không mua) ✅
- [ ] Liên hệ admin (form) ✅

### ✅ Bảo Mật
- [ ] Admin role KHÔNG thấy customer dashboard
- [ ] User role KHÔNG thấy customer dashboard
- [ ] Customer KHÔNG thấy admin menu

---

## 📊 DATABASE CHECK (Optional)

Nếu muốn kiểm tra dữ liệu trong database:

```sql
-- Check user registration
SELECT * FROM users WHERE email = 'customer@demo.com';

-- Expected result:
-- | id | email | role | full_name | ... |
-- | xx | customer@demo.com | customer | Khách Hàng Demo | ... |

-- Check products
SELECT * FROM products WHERE status = 'active' LIMIT 5;

-- Expected: Ít nhất 5 sản phẩm hoặc tùy vào database
```

---

## 🔧 TROUBLESHOOT

Nếu gặp lỗi:

### ❌ "Sản phẩm không hiển thị"
→ Kiểm tra: Database có bảng `products` với `status = 'active'` không?

### ❌ "Error 500 sau gửi form"
→ Kiểm tra: File logs trong `storage/logs/`

### ❌ "Dashboard không hiển thị"
→ Kiểm tra: File `views/dashboard/customer.php` tồn tại?

### ❌ "Không thể chọn 'Khách Hàng' khi đăng ký"
→ Kiểm tra: Form `register.php` có phần `<select role>`?

---

## 📝 NOTES

- Database.php cần kết nối MySQL/MariaDB
- Laragon cần START Apache + MySQL
- Các file CSS viết inline trong customer.php (không cần CSS file riêng)
- Form contact gửi tới `/contact/send` route
- Session user_id bắt buộc để render customer dashboard

---

## ✅ HOÀN THÀNH

Khi cả 3 scenario đều PASS → Feature customer hoàn thành!

```
SCENARIO 1: Register Customer ✅
SCENARIO 2: View Products ✅
SCENARIO 3: Send Contact Message ✅

FEATURE STATUS: ✅ READY FOR PRODUCTION
```
