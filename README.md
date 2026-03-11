# Hướng Dẫn Sử Dụng Du An Xuong

## 📋 Mục Lục
1. [Cài Đặt & Khởi Động](#cài-đặt--khởi-động)
2. [Cấu Trúc Dự Án](#cấu-trúc-dự-án)
3. [Chức Năng Chính](#chức-năng-chính)
4. [Hướng Dẫn Sử Dụng](#hướng-dẫn-sử-dụng)

## 🚀 Cài Đặt & Khởi Động

### Bước 1: Cấu Hình Cơ Sở Dữ Liệu

1. Tạo file `.env` trong thư mục gốc dựa trên `.env.example`:
```
APP_NAME=Du An Xuong
APP_ENV=development
APP_DEBUG=true

DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=du_an_xuong
DB_PORT=3306

UPLOAD_PATH=/storage/uploads
SESSION_TIMEOUT=3600
```

2. Nhập cơ sở dữ liệu:
   - Mở phpMyAdmin
   - Tạo cơ sở dữ liệu: `du_an_xuong`
   - Nhập file `database.sql`

### Bước 2: Khởi Động Ứng Dụng

```bash
# Di chuyển đến thư mục dự án
cd c:\laragon\www\du_an_xuong

# Truy cập qua Laragon
# Mở trình duyệt: http://localhost/du_an_xuong/public/login
```

## 📁 Cấu Trúc Dự Án

```
du_an_xuong/
├── app/
│   ├── Controllers/          # Các controller (xử lý logic)
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── ProjectController.php
│   │   ├── TaskController.php
│   │   └── OtherControllers.php
│   └── Models/              # Mô hình dữ liệu
│       ├── User.php
│       ├── Project.php
│       ├── Task.php
│       └── Other.php
├── src/
│   ├── Database.php         # Lớp kết nối cơ sở dữ liệu
│   └── Auth.php             # Lớp xác thực
├── views/                   # Giao diện HTML/PHP
│   ├── layout.php           # Layout chính
│   ├── auth/
│   ├── dashboard/
│   ├── projects/
│   ├── tasks/
│   ├── users/
│   ├── categories/
│   ├── teams/
│   └── errors/
├── routes/
│   └── web.php             # Cấu hình định tuyến
├── storage/
│   ├── uploads/            # Tải lên tệp
│   ├── logs/               # Nhật ký
│   └── compiles/           # Blade cache
├── public/
│   └── index.php           # Điểm vào ứng dụng
├── vendor/                 # Thư viện Composer
├── database.sql            # Dump cơ sở dữ liệu
└── .env.example            # Tệp cấu hình mẫu
```

## 🎯 Chức Năng Chính

### 1. **Xác Thực Người Dùng** (Auth)
- ✅ Đăng nhập
- ✅ Đăng ký
- ✅ Đăng xuất
- ✅ Quản lý hồ sơ cá nhân
- ✅ Đổi mật khẩu

### 2. **Quản Lý Người Dùng** (User Management)
- ✅ Xem danh sách người dùng
- ✅ Tạo người dùng mới
- ✅ Chỉnh sửa thông tin người dùng
- ✅ Xóa người dùng
- ✅ Gán vai trò (Admin/User)

### 3. **Quản Lý Danh Mục** (Categories)
- ✅ Xem danh sách danh mục
- ✅ Tạo danh mục mới
- ✅ Chỉnh sửa danh mục
- ✅ Xóa danh mục
- ✅ Tùy chỉnh biểu tượng & màu sắc

### 4. **Quản Lý Dự Án** (Projects)
- ✅ Xem danh sách dự án
- ✅ Tạo dự án mới
- ✅ Chỉnh sửa dự án
- ✅ Xóa dự án
- ✅ Gán dự án cho người dùng
- ✅ Theo dõi tiến độ
- ✅ Quản lý ngân sách & lịch trình

### 5. **Quản Lý Tác Vụ** (Tasks)
- ✅ Xem danh sách tác vụ
- ✅ Tạo tác vụ trong dự án
- ✅ Chỉnh sửa trạng thái tác vụ
- ✅ Xóa tác vụ
- ✅ Gán tác vụ cho người dùng
- ✅ Theo dõi hạn chót (`todo`, `in_progress`, `completed`)
- ✅ Thêm bình luận
- ✅ Tải lên tệp đính kèm

### 6. **Quản Lý Đội Nhóm** (Teams)
- ✅ Tạo đội nhóm
- ✅ Gán lãnh đạo đội
- ✅ Thêm/xóa thành viên
- ✅ Gán vị trí trong đội
- ✅ Xem danh sách thành viên

### 7. **Bảng Điều Khiển** (Dashboard)
- ✅ Thống kê tổng quát (Admin)
- ✅ Danh sách tác vụ quá hạn (User)
- ✅ Danh sách tác vụ sắp tới (User)
- ✅ Hoạt động gần đây

## 👤 Vai Trò & Quyền

### Admin
- Truy cập tất cả chức năng
- Quản lý người dùng
- Quản lý danh mục
- Quản lý đội nhóm
- Xem tất cả dự án & tác vụ

### User (Người Dùng)
- Xem dự án được gán
- Quản lý tác vụ của mình
- Tham gia đội nhóm
- Xem hồ sơ cá nhân

## 🔐 Tài Khoản Mặc Định

Sau khi import `database.sql`, có 2 tài khoản mặc định:

**Admin:**
- Email: `admin@example.com`
- Mật khẩu: `123456`

**User:**
- Email: `user@example.com`
- Mật khẩu: `123456`

## 📝 Hướng Dẫn Sử Dụng

### Tạo Người Dùng Mới (Admin)

1. Đăng nhập với tài khoản Admin
2. Chọn **Quản lý Người dùng**
3. Nhấp **+ Tạo Người Dùng**
4. Điền thông tin:
   - Tên đăng nhập
   - Email
   - Họ và tên
   - Số điện thoại (tùy chọn)
   - Mật khẩu
   - Vai trò (Admin/User)
5. Nhấp **Lưu**

### Tạo Dự Án Mới (Admin)

1. Chọn **Quản lý Dự án**
2. Nhấp **+ Tạo Dự Án**
3. Điền thông tin:
   - Tên dự án
   - Mô tả
   - Danh mục
   - Người theo dõi
   - Trạng thái
   - Ngày bắt đầu & kết thúc
   - Ngân sách
4. Nhấp **Lưu**

### Tạo Tác Vụ (Admin/User)

1. Chọn **Tác vụ**
2. Nhấp **+ Tạo Tác Vụ**
3. Điền thông tin:
   - Tiêu đề
   - Mô tả
   - Dự án
   - Người được gán
   - Trạng thái
   - Hạn chót
   - Tiến độ (%)
4. Nhấp **Lưu**

### Thêm Bình Luận & Tệp Đính Kèm

1. Vào chi tiết tác vụ
2. Cuộn xuống phần **Bình Luận**
3. Nhập bình luận và nhấp **Gửi**
4. Để tải lên tệp:
   - Chọn tệp từ máy tính
   - Nhấp **Tải lên**
   - Tệp sẽ được lưu trong `/storage/uploads/`

### Quản Lý Đội Nhóm

1. Chọn **Quản lý Đội nhóm**
2. Nhấp **+ Tạo Đội Nhóm**
3. Điền tên, mô tả, lãnh đạo
4. Nhấp **Lưu**
5. Để thêm thành viên:
   - Chọn đội nhóm từ danh sách
   - Nhấp **Thêm Thành Viên**
   - Chọn người dùng & vị trí

## 🗄️ Cơ Sở Dữ Liệu

### Bảng Chính

1. **users** - Người dùng hệ thống
2. **categories** - Danh mục dự án
3. **projects** - Dự án
4. **tasks** - Tác vụ trong dự án
5. **teams** - Đội nhóm
6. **team_members** - Thành viên đội
7. **accounts** - Tài khoản & đăng ký
8. **comments** - Bình luận trên tác vụ
9. **attachments** - Tệp đính kèm
10. **activity_logs** - Nhật ký hoạt động

## 🔧 Xử Lý Sự Cố

### Lỗi Kết Nối Cơ Sở Dữ Liệu
- Kiểm tra file `.env` có cấu hình đúng
- Kiểm tra MySQL đang chạy
- Kiểm tra tên cơ sở dữ liệu `du_an_xuong`

### Lỗi Tệp Không Tìm Thấy
- Kiểm tra đường dẫn file `.env`
- Kiểm tra quyền thư mục `/storage`

### Lỗi Tải Lên Tệp
- Kiểm tra thư mục `/storage/uploads` tồn tại & có quyền ghi
- Kiểm tra dung lượng file không vượt quá giới hạn

## 📚 Thư Viện Sử Dụng
- **Bramus Router** - Định tuyến URL
- **BladeOne** - Mẫu nhanh (tùy chọn)
- **Rakit Validation** - Xác thực dữ liệu
- **Vlucas PhpDotenv** - Quản lý biến môi trường

## 📞 Hỗ Trợ

Nếu gặp vấn đề:
1. Kiểm tra lại cấu hình `.env`
2. Xóa cache `/storage/compiles`
3. Kiểm tra error logs
4. Liên hệ quản trị viên

---

**Phiên bản:** 1.0  
**Cập nhật lần cuối:** 2026
