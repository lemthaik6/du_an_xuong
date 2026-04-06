# HƯỚNG DẪN PHÂN CÔNG THÀNH VIÊN LÀM TÁC VỤ

## 📋 GIỚI THIỆU TÍNH NĂNG

Tính năng này cho phép **Admin** gán nhiều **thành viên đội nhóm** cho một **tác vụ** trong dự án.

### Lợi Ích:
- ✅ Gán tác vụ cho nhiều người cùng lúc
- ✅ Theo dõi thành viên nào làm tác vụ nào
- ✅ Tự động lấy danh sách từ đội nhóm của dự án
- ✅ Cập nhật phân công bất kỳ lúc nào

---

## 🔧 SETUP ĐÃ HOÀN THÀNH

### 1. Database
- ✅ Tạo bảng `task_members` (junction table)
  - Liên kết giữa `tasks` và `users` (many-to-many)
  - Cột: `id`, `task_id`, `user_id`, `assigned_date`
  - UNIQUE constraint trên `(task_id, user_id)` để tránh trùng lặp

### 2. Model (Task.php)
Thêm 4 phương thức:
- `getAssignedMembers($taskId)` - Lấy danh sách thành viên được gán
- `assignMembers($taskId, $userIds)` - Gán nhiều thành viên cho tác vụ
- `isMemberAssigned($taskId, $userId)` - Kiểm tra thành viên có được gán hay không
- `unassignMember($taskId, $userId)` - Hủy gán 1 thành viên

### 3. Controller (TaskController.php)
- **show()** - Cập nhật để lấy danh sách thành viên được gán + danh sách thành viên có sẵn
  - Variables: `$assignedMembers`, `$allTeamMembers`, `$isAdmin`

- **updateMembers()** - Phương thức mới để xử lý cập nhật phân công
  - Yêu cầu: POST request
  - Kiểm tra quyền (Admin hoặc người tạo tác vụ)
  - Lấy danh sách member IDs từ checkbox
  - Gọi `Task::assignMembers()` để lưu

### 4. Routes (web.php)
```
POST /tasks/:id/update-members → TaskController@updateMembers
```

### 5. View (tasks/show.php)
- Thêm section "👥 Phân Công Thành Viên Làm Tác Vụ" (Admin only)
- Hiển thị checkbox cho mỗi thành viên
- Form để submit phân công mới
- Danh sách thành viên được gán hiện tại

---

## 🚀 HƯỚNG DẪN SỬ DỤNG

### Prerequisite:
1. ✅ Dự án phải có ít nhất **1 đội nhóm được gán**
2. ✅ Đội nhóm phải có ít nhất **1 thành viên**
3. ✅ Phải có tác vụ trong dự án đó
4. ✅ Phải đăng nhập với vai trò **Admin** hoặc **người tạo tác vụ**

### Bước 1: Truy cập Chi Tiết Tác Vụ
```
URL: http://localhost/du_an_xuong/public/tasks/{task_id}
Ví dụ: http://localhost/du_an_xuong/public/tasks/1
```

### Bước 2: Tìm Section "👥 Phân Công Thành Viên"
- Section này **chỉ hiển thị khi đăng nhập là Admin**
- Section có background xanh nhạt (#e8f4f8)
- Tiêu đề: "👥 Phân Công Thành Viên Làm Tác Vụ"

### Bước 3: Chọn Thành Viên
- Mỗi thành viên hiểu một checkbox
- ✅ Kiểm checkbox để gán thành viên
- ❌ Bỏ checkbox để hủy gán thành viên
- Danh sách được lấy từ **đội nhóm của dự án**

### Bước 4: Cập Nhật Phân Công
- Nhấn nút "💾 Cập Nhật Phân Công"
- Hệ thống sẽ:
  1. Xóa những phân công cũ
  2. Thêm những phân công mới (từ checkbox)
  3. Hiển thị thông báo Success
  4. Refresh trang để thấy danh sách cập nhật

### Bước 5: Xem Danh Sách Thành Viên Được Gán
- Section "✅ Thành Viên Được Gán Làm Tác Vụ Này"
- Liệt kê tên và email của các thành viên
- Cập nhật theo thời gian thực

---

## 📊 TEST SCENARIO

### SCENARIO 1: Gán Một Thành Viên

**Pre-conditions:**
- Admin đã đăng nhập
- Có dự án "Sample Project" (ID=1)
- Dự án có đội nhóm "Dev Team" với 3 thành viên:
  * Nguyễn Văn A (a@example.com)
  * Nguyễn Văn B (b@example.com)
  * Nguyễn Văn C (c@example.com)
- Có tác vụ "Fix bug #123" (ID=5) trong dự án này

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/tasks/5
2. Scroll xuống tìm section "👥 Phân Công Thành Viên Làm Tác Vụ"
3. Checkbox "Nguyễn Văn A"
4. Nhấn "💾 Cập Nhật Phân Công"

**Expected Result:**
```
✅ Thông báo: "Cập nhật phân công tác vụ thành công"
✅ Section "✅ Thành Viên Được Gán Làm Tác Vụ Này" hiện:
   - Nguyễn Văn A (a@example.com)
```

---

### SCENARIO 2: Gán Nhiều Thành Viên

**Pre-conditions:** (Giống SCENARIO 1)

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/tasks/5
2. Checkbox "Nguyễn Văn A", "Nguyễn Văn B", "Nguyễn Văn C"
3. Nhấn "💾 Cập Nhật Phân Công"

**Expected Result:**
```
✅ Thông báo: "Cập nhật phân công tác vụ thành công"
✅ Section "✅ Thành Viên Được Gán Làm Tác Vụ Này" hiện:
   - Nguyễn Văn A (a@example.com)
   - Nguyễn Văn B (b@example.com)
   - Nguyễn Văn C (c@example.com)
```

---

### SCENARIO 3: Hủy Phân Công

**Pre-conditions:**
- Tác vụ ID=5 đã có 3 thành viên được gán (từ SCENARIO 2)

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/tasks/5
2. Bỏ checkbox "Nguyễn Văn B" (chỉ có A và C được checked)
3. Nhấn "💾 Cập Nhật Phân Công"

**Expected Result:**
```
✅ Thông báo: "Cập nhật phân công tác vụ thành công"
✅ Section "✅ Thành Viên Được Gán Làm Tác Vụ Này" chỉ hiện:
   - Nguyễn Văn A (a@example.com)
   - Nguyễn Văn C (c@example.com)
```

---

### SCENARIO 4: Hủy Tất Cả Phân Công

**Pre-conditions:**
- Tác vụ ID=5 đã có thành viên được gán

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/tasks/5
2. Bỏ tất cả checkbox
3. Nhấn "💾 Cập Nhật Phân Công"

**Expected Result:**
```
✅ Thông báo: "Cập nhật phân công tác vụ thành công"
✅ Section "✅ Thành Viên Được Gán Làm Tác Vụ Này" không hiểu
   (vì không còn thành viên nào được gán)
```

---

### SCENARIO 5: Không Có Đội Nhóm Gán

**Pre-conditions:**
- Dự án "No Team Project" (ID=2) không có đội nhóm được gán
- Có tác vụ "Some task" (ID=10) trong dự án này

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/tasks/10
2. Scroll xuống section "👥 Phân Công Thành Viên Làm Tác Vụ"

**Expected Result:**
```
⚠️ Thông báo: "Dự án này chưa có đội nhóm được gán. Vui lòng gán đội nhóm cho dự án trước."
❌ Không có checkbox để chọn
```

---

## 🔐 BẢO MẬT

### Permission Check:
- ✅ Chỉ **Admin** hoặc **người tạo tác vụ** mới có thể cập nhật phân công
- ✅ Non-admin users **không thấy section phân công**
- ✅ Kiểm tra `requireLogin()` khi truy cập endpoint
- ✅ Kiểm tra quyền trước khi update database

### Input Validation:
- ✅ Kiểm tra `task_id` không rỗng
- ✅ Kiểm tra `member_ids` là array hợp lệ
- ✅ Filter các ID không phải số
- ✅ UNIQUE constraint trong database tránh trùng lặp

---

## 📁 CẤU TRÚC TỆP

### Model
**File:** `app/Models/Task.php`
**Methods:**
```php
public function getAssignedMembers($taskId)
public function assignMembers($taskId, $userIds)
public function isMemberAssigned($taskId, $userId)
public function unassignMember($taskId, $userId)
```

### Controller
**File:** `app/Controllers/TaskController.php`
**Methods:**
```php
public function show($id)          // Updated: add members
public function updateMembers()    // New method
```

### View
**File:** `views/tasks/show.php`
**Section:** "👥 Phân Công Thành Viên Làm Tác Vụ" (lines ~65-120)

### Routes
**File:** `routes/web.php`
**Route:**
```php
$router->post('/tasks/(\d+)/update-members', TaskController::class . '@updateMembers');
```

### Database
**Table:** `task_members`
**Columns:** `id`, `task_id`, `user_id`, `assigned_date`
**Constraints:**
- FK `task_id` → `tasks.id` (ON DELETE CASCADE)
- FK `user_id` → `users.id` (ON DELETE CASCADE)
- UNIQUE `(task_id, user_id)`

---

## ✅ VERIFICATION CHECKLIST

Sau khi implement, kiểm tra các điểm sau:

- [ ] Database table `task_members` được tạo
- [ ] Task model có 4 phương thức mới
- [ ] TaskController `show()` method cập nhật với members data
- [ ] TaskController có phương thức `updateMembers()`
- [ ] Route POST `/tasks/:id/update-members` được thêm
- [ ] View `tasks/show.php` có section phân công (admin only)
- [ ] Checkbox form render đúng
- [ ] Form submit thành công
- [ ] Danh sách cập nhật sau khi submit
- [ ] Thông báo Flash message hiển thị

---

## 🐛 TROUBLESHOOT

### ❌ "Section phân công không hiển thị"
→ Kiểm tra:
1. Bạn đã đăng nhập với vai trò Admin chưa?
2. Dự án có đội nhóm được gán chưa? (check `/projects/:id`)
3. Đội nhóm có thành viên chưa? (check `/teams/:id`)

### ❌ "Form submit nhưng không có phản hồi"
→ Kiểm tra:
1. Network tab trong DevTools có request POST không?
2. Response status code là gì? (200, 404, 500?)
3. File logs trong `storage/logs/` có lỗi gì không?

### ❌ "Danh sách thành viên không cập nhật"
→ Kiểm tra:
1. Form submit thành công chưa? (thông báo xanh có không?)
2. Database có record trong `task_members` không? (check phpMyAdmin)
3. Refresh trang xem có data không?

### ❌ "Lỗi 404 sau khi submit"
→ Kiểm tra:
1. Route trong `web.php` có đúng không?
2. TaskController method `updateMembers()` tồn tại chưa?
3. Regex pattern `(\d+)` có match task_id không?

---

## 📝 LƯỚI GHI

- Tất cả member IDs được validate trước khi lưu
- Database sử dụng transaction-like behavior (xóa hết, insert mới)
- Email notifications có thể thêm sau (bây giờ chỉ Flash message)
- Audit log có thể track ai đã phân công lúc nào

---

## ✅ HOÀN THÀNH

Tính năng phân công thành viên làm tác vụ **HOÀN THÀNH & SẴN DÙNG** 🎉

```
TEST ALL 5 SCENARIOS → DEPLOYMENT READY ✅
```
