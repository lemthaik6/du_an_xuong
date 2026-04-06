# HƯỚNG DẪN PHÂN CÔNG TÁC VỤ TỪ TRANG DANH SÁCH TÁC VỤ

## 📋 GIỚI THIỆU TÍNH NĂNG

Tính năng này cho phép **Admin** phân công **thành viên** cho **tác vụ** trực tiếp từ trang danh sách tác vụ (`/tasks`).

### Lợi Ích:
- ✅ Phân công nhanh mà không cần vào chi tiết tác vụ
- ✅ Modal popup trực quan với checkbox
- ✅ Hiển thị thành viên từ đội nhóm được gán cho dự án
- ✅ Hiển thị thành viên đã được gán hiện tại
- ✅ AJAX load danh sách thành viên (nhanh & responsive)

---

## 🔧 SETUP ĐÃ HOÀN THÀNH

### 1. View (views/tasks/index.php)
- ✅ Thêm nút "👥 Phân Công" vào bảng tác vụ (cột Hành Động)
- ✅ Thêm modal popup để chọn thành viên
- ✅ JavaScript function `openTaskMembersModal(taskId, taskTitle)`
- ✅ JavaScript xử lý form submit động

### 2. Controller (TaskController.php)
- ✅ Thêm method `getMembers($taskId)` - AJAX endpoint
  - Lấy task info
  - Lấy project info
  - Lấy thành viên từ dự án (đội nhóm)
  - Lấy danh sách thành viên đã được gán
  - Trả về JSON

### 3. Routes (routes/web.php)
- ✅ Thêm GET route: `/tasks/:id/get-members` → TaskController@getMembers

---

## 🚀 HƯỚNG DẪN SỬ DỤNG

### Prerequisite:
1. ✅ Phải đăng nhập với vai trò **Admin**
2. ✅ Dự án có tác vụ phải có **đội nhóm được gán**
3. ✅ Đội nhóm phải có **thành viên**

### Bước 1: Truy cập Danh Sách Tác Vụ
```
URL: http://localhost/du_an_xuong/public/tasks
```

### Bước 2: Tìm Nút "👥 Phân Công"
- Mỗi tác vụ trong bảng có 4 nút hành động:
  - 🔵 **Xem** - Xem chi tiết
  - 🟡 **Sửa** - Chỉnh sửa tác vụ
  - 🔵 **👥 Phân Công** ← **CLICK CÁI NÀY**
  - 🔴 **Xóa** - Xóa tác vụ

### Bước 3: Click "👥 Phân Công"
- Modal popup xuất hiện
- Hiển thị tên tác vụ
- Hiển thị danh sách thành viên (loading from AJAX)
- Thành viên được gán hiện tại sẽ được **check sẵn**

### Bước 4: Chọn Thành Viên
- ✅ **Tick checkbox** để gán thành viên
- ❌ **Bỏ checkbox** để hủy gán
- Có thể chọn **0 hoặc nhiều** thành viên

### Bước 5: Phân Công
- Nhấn nút "✓ Phân Công"
- Form submit với POST đến `/tasks/:id/update-members`
- Thông báo Success hiển thị
- Quay lại trang danh sách tác vụ

### Bước 6: Kiểm Tra Kết Quả (Optional)
- Click "Xem" để xem chi tiết tác vụ
- Scroll xuống tìm section "👥 Phân Công Thành Viên"
- Xem danh sách thành viên được gán

---

## 📊 TEST SCENARIO

### SCENARIO 1: Phân Công Một Thành Viên

**Pre-conditions:**
- Admin đã đăng nhập
- Bảng danh sách tác vụ có ít nhất 1 tác vụ
- Tác vụ đó có dự án có đội nhóm được gán
- Đội nhóm có ít nhất 1 thành viên

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/tasks
2. Tìm một tác vụ từ dự án có đội nhóm
3. Click nút "👥 Phân Công"
4. Modal popup xuất hiện, chờ load danh sách
5. Checkbox 1 thành viên
6. Nhấn "✓ Phân Công"

**Expected Result:**
```
✅ Modal đóng
✅ Thông báo Success: "Cập nhật phân công tác vụ thành công"
✅ Quay lại trang danh sách
✅ (Optional) Vào chi tiết tác vụ → thành viên được gán
```

---

### SCENARIO 2: Phân Công Nhiều Thành Viên

**Pre-conditions:** (Giống SCENARIO 1)

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/tasks
2. Click "👥 Phân Công" cho 1 tác vụ
3. Checkbox 3 thành viên
4. Nhấn "✓ Phân Công"

**Expected Result:**
```
✅ Cả 3 thành viên được gán cho tác vụ
```

---

### SCENARIO 3: Cập Nhật Phân Công (Hủy Gán)

**Pre-conditions:**
- Tác vụ đã có thành viên được gán từ SCENARIO 1

**Steps:**
1. Click "👥 Phân Công" cho tác vụ đó
2. Thành viên cũ sẽ được **check sẵn**
3. Bỏ checkbox thành viên cũ
4. Nhấn "✓ Phân Công"

**Expected Result:**
```
✅ Thành viên cũ bị hủy gán
✅ Section "👥 Phân Công Thành Viên" ở trang chi tiết sẽ trống
```

---

### SCENARIO 4: Dự Án Không Có Đội Nhóm

**Pre-conditions:**
- Có 1 tác vụ từ dự án không có đội nhóm được gán

**Steps:**
1. Click "👥 Phân Công" cho tác vụ đó
2. Chờ load modal

**Expected Result:**
```
⚠️ Modal hiển thị:
   "⚠️ Không có thành viên nào để phân công. Dự án chưa có đội nhóm được gán."
```

---

## 🔐 BẢO MẬT

### Permission Check:
- ✅ Chỉ **Admin** thấy nút "Phân Công"
- ✅ Endpoint `/tasks/:id/get-members` kiểm tra requireLogin()
- ✅ TaskController::updateMembers() kiểm tra quyền

### Data Validation:
- ✅ Và kiểm task_id hợp lệ
- ✅ Kiểm tra member_ids là array
- ✅ Filter các ID không phải số
- ✅ Chỉ lấy thành viên từ đội nhóm của dự án

---

## 📁 CẤU TRÚC TỆP

### View
**File:** `views/tasks/index.php`
**Changes:**
- Thêm nút "👥 Phân Công" trong cột Hành Động
- Thêm modal HTML
- Thêm JavaScript functions

### Controller
**File:** `app/Controllers/TaskController.php`
**New Method:**
```php
public function getMembers($taskId) {
    // Return JSON with members and assigned members
}
```

### Routes
**File:** `routes/web.php`
**New Route:**
```php
$router->get('/tasks/(\d+)/get-members', TaskController::class . '@getMembers');
```

---

## 💡 TECHNICAL DETAILS

### JavaScript Flow:
1. User click "👥 Phân Công" button
2. `openTaskMembersModal(taskId, taskTitle)` called
3. AJAX GET `/tasks/:id/get-members`
4. Render checkboxes từ response
5. Display modal
6. User chọn members
7. Form submit POST `/tasks/:id/update-members`
8. TaskController::updateMembers() handle
9. Redirect + Flash message

### AJAX Response Format:
```json
{
    "success": true,
    "members": [
        {
            "id": 1,
            "full_name": "Nguyễn Văn A",
            "email": "a@example.com"
        }
    ],
    "assignedMembers": [1, 3]
}
```

### Form Action:
- Dynamic: `<form method="POST" action="/tasks/{taskId}/update-members">`
- Reuse existing `TaskController::updateMembers()` endpoint

---

## ✅ VERIFICATION CHECKLIST

- [ ] Nút "👥 Phân Công" hiển thị trong bảng tác vụ
- [ ] Click nút → modal popup
- [ ] Modal load danh sách members via AJAX
- [ ] Pre-checked members từ database
- [ ] Checkbox hoạt động
- [ ] Form submit → updateMembers endpoint
- [ ] Thông báo Success hiển thị
- [ ] Redirect đến danh sách tác vụ
- [ ] Members được gán (check in task detail)

---

## 🐛 TROUBLESHOOT

### ❌ "Nút Phân Công không hiển thị"
→ Kiểm tra:
1. Bạn là Admin chưa?
2. Refresh trang
3. Check console: F12 → Network tab

### ❌ "Modal không hiển thị"
→ Kiểm tra:
1. JavaScript có lỗi? (F12 → Console)
2. Browser zoom level bình thường?
3. Modal HTML render đúng?

### ❌ "Modal mở nhưng trống"
→ AJAX load members failed:
1. Check Network tab (F12)
2. GET `/tasks/:id/get-members` status code?
3. JSON response hợp lệ?
4. Task có dự án không?
5. Dự án có đội nhóm không?

### ❌ "Form submit nhưng không có phản hồi"
→ Kiểm tra:
1. Post request có được gửi không?
2. Task ID được set đúng không?
3. Member checkbox có được checked không?

---

## 📝 LƯỚI GHI

- Modal popup với fixed position z-index 1000
- AJAX load members (responsive & nhanh)
- Pre-checked members từ DB
- Form action set dynamic từ JavaScript
- Reuse existing updateMembers endpoint
- No new database tables needed
- Modal đóng khi click outside hoặc cancel

---

## ✅ HOÀN THÀNH

Tính năng phân công tác vụ từ danh sách **HOÀN THÀNH & SẴN DÙNG** 🎉

```
FEATURES:
✅ Quick assign button in task list
✅ Modal popup interface
✅ AJAX load team members
✅ Pre-checked assigned members
✅ Multi-select members
✅ Submit to existing endpoint
✅ Success notification
✅ Auto-redirect

STATUS: READY FOR PRODUCTION ✅
```
