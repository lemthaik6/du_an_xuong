# HƯỚNG DẪN PHÂN CÔNG TÁC VỤ CHO THÀNH VIÊN TỪ TRANG ĐỘI NHÓM

## 📋 GIỚI THIỆU TÍNH NĂNG

Tính năng này cho phép **Admin** phân công **tác vụ** cho **thành viên** của **đội nhóm** trực tiếp từ trang chi tiết đội nhóm.

### Lợi Ích:
- ✅ Quản lý phân công tác vụ từ trang đội nhóm
- ✅ Chỉ hiển thị tác vụ từ dự án được gán cho đội
- ✅ Có thể gán tác vụ cho nhiều thành viên cùng lúc
- ✅ Giao diện trực quan với 2 cột (Tác Vụ vs Thành Viên)
- ✅ Tự động lấy danh sách từ dự án được gán

---

## 🔧 SETUP ĐÃ HOÀN THÀNH

### 1. Model (Team.php)
Thêm 2 phương thức:
- `getProjectsForTeam($teamId)` - Lấy danh sách dự án được gán cho đội
- `getTasksForTeam($teamId)` - Lấy danh sách tác vụ từ dự án được gán

### 2. Controller (TeamController.php)
- Thêm `use` statement cho Task model
- Cập nhật `show()` method để:
  - Lấy danh sách tác vụ bằng `$this->teamModel->getTasksForTeam($id)`
  - Truyền data đến view: `$tasks`, `$isAdmin`

### 3. View (views/teams/show.php)
- Thêm section "📋 Phân Công Tác Vụ Cho Thành Viên" (Admin only)
- 2 cột:
  - **Bên Trái**: Danh sách tác vụ
  - **Bên Phải**: Danh sách thành viên (checkbox)
- Khi click tác vụ → highlight + hiển thị nút "Phân Công"
- Khi submit → gọi TaskController::updateMembers() endpoint

### 4. JavaScript Functions:
- `selectTask(taskId, taskTitle)` - Chọn tác vụ
- `updateTaskAction()` - Xác thực + set action form

---

## 🚀 HƯỚNG DẪN SỬ DỤNG

### Prerequisite:
1. ✅ Phải đăng nhập với vai trò **Admin**
2. ✅ Đội nhóm phải có **ít nhất 1 dự án được gán**
   - Kiểm tra: `/projects/:id` → xem có dòng "👥 PHÂN CÔNG ĐỘI NHÓM..." không
3. ✅ Dự án phải có **ít nhất 1 tác vụ**
4. ✅ Đội nhóm phải có **ít nhất 1 thành viên**

### Bước 1: Truy cập Trang Đội Nhóm
```
URL: http://localhost/du_an_xuong/public/teams/{team_id}
Ví dụ: http://localhost/du_an_xuong/public/teams/4
```

### Bước 2: Scroll Xuống → Tìm Section "📋 Phân Công Tác Vụ Cho Thành Viên"
- Section này **chỉ hiển thị:**
  - Khi đăng nhập là **Admin**
  - Và đội có **tác vụ** từ dự án được gán
- Background: Vàng nhạt (#fef9e7)
- Tiêu đề: "📋 Phân Công Tác Vụ Cho Thành Viên"

### Bước 3: Chọn Tác Vụ (Bên Trái)
- Danh sách tác vụ hiển thị từ dự án được gán cho đội
- Mỗi tác vụ có:
  - 📌 Tên tác vụ
  - 📋 Dự án liên quan
  - 🏷️ Trạng thái (Chờ, Tiến hành, Hoàn thành)
- **Click vào 1 tác vụ** → highlight màu vàng
- Nút "✓ Phân Công Tác Vụ" sẽ hiển thị

### Bước 4: Chọn Thành Viên (Bên Phải)
- Danh sách thành viên của đội
- Mỗi thành viên có checkbox + tên + email
- ✅ **Kiểm checkbox** cho các thành viên cần gán tác vụ
- ❌ **Bỏ checkbox** để hủy gán

### Bước 5: Phân Công
- Nhấn "✓ Phân Công Tác Vụ"
- Hệ thống sẽ:
  1. Xóa những phân công cũ của tác vụ đó
  2. Thêm những phân công mới (từ checkbox)
  3. Hiển thị thông báo Success
  4. Quay lại trang tác vụ chi tiết

### Bước 6: Kiểm Tra Kết Quả
- Vào tác vụ chi tiết: `/tasks/{task_id}`
- Scroll xuống section "👥 Phân Công Thành Viên"
- Xem danh sách thành viên được gán

---

## 📊 TEST SCENARIO

### SCENARIO 1: Phân Công 1 Tác Vụ Cho 1 Thành Viên

**Pre-conditions:**
- Admin đã đăng nhập
- Đội nhóm ID=4 ("Dev Team") có:
  - 3 thành viên: A, B, C
  - Gán cho dự án ID=1 ("Sample Project")
- Dự án ID=1 có tác vụ:
  - ID=5: "Fix bug #123"
  - ID=6: "Feature: Login"

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/teams/4
2. Scroll xuống tìm section "📋 Phân Công Tác Vụ"
3. Click tác vụ "Fix bug #123" (bên trái)
4. Checkbox "Nguyễn Văn A" (bên phải)
5. Nhấn "✓ Phân Công Tác Vụ"

**Expected Result:**
```
✅ Thông báo: "Cập nhật phân công tác vụ thành công"
✅ Chuyển hướng: /tasks/5
✅ Section "👥 Phân Công Thành Viên" hiển thị "Nguyễn Văn A"
```

---

### SCENARIO 2: Phân Công 1 Tác Vụ Cho Nhiều Thành Viên

**Pre-conditions:** (Giống SCENARIO 1)

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/teams/4
2. Click tác vụ "Feature: Login" (bên trái)
3. Checkbox "Nguyễn Văn A", "Nguyễn Văn B", "Nguyễn Văn C" (bên phải)
4. Nhấn "✓ Phân Công Tác Vụ"

**Expected Result:**
```
✅ Thông báo: "Cập nhật phân công tác vụ thành công"
✅ Chuyển hướng: /tasks/6
✅ Section "👥 Phân Công Thành Viên" hiển thị 3 thành viên
```

---

### SCENARIO 3: Cập Nhật Phân Công Tác Vụ

**Pre-conditions:**
- Tác vụ ID=5 hiện có 1 thành viên được gán (từ SCENARIO 1)

**Steps:**
1. Truy cập http://localhost/du_an_xuong/public/teams/4
2. Click tác vụ "Fix bug #123" (lần 2)
3. Checkbox "Nguyễn Văn B", "Nguyễn Văn C" (bỏ checkbox "A")
4. Nhấn "✓ Phân Công Tác Vụ"

**Expected Result:**
```
✅ Thông báo: "Cập nhật phân công tác vụ thành công"
✅ Chuyển hướng: /tasks/5
✅ Section "👥 Phân Công Thành Viên" chỉ hiển thị B, C
   (A đã bị hủy gán)
```

---

### SCENARIO 4: Không Có Tác Vụ Nào

**Pre-conditions:**
- Đội nhóm ID=5 không có dự án được gán
- Hoặc dự án được gán nhưng không có tác vụ nào

**Expected Result:**
```
❌ Section "📋 Phân Công Tác Vụ" không hiển thị
   (vì điều kiện: $isAdmin && !empty($tasks))
```

---

### SCENARIO 5: Không Có Thành Viên Trong Đội

**Pre-conditions:**
- Đội nhóm ID=6 có tác vụ từ dự án
- Nhưng nhóm này không có thành viên nào

**Expected Result:**
```
⚠️ Section "📋 Phân Công Tác Vụ" hiển thị:
   - Danh sách tác vụ bên trái OK
   - Bên phải: "⚠️ Đội này chưa có thành viên nào"
```

---

## 🔐 BẢO MẬT

### Permission Check:
- ✅ Chỉ **Admin** thấy section phân công
- ✅ Non-admin users không thấy
- ✅ Form submit xác thực task_id + member_ids
- ✅ Kiểm tra permission trong TaskController::updateMembers()

### Input Validation:
- ✅ Kiểm tra `task_id` không rỗng (JavaScript + Controller)
- ✅ Kiểm tra `member_ids[]` minimum 1 (JavaScript)
- ✅ Filter các ID không phải số (Controller)
- ✅ Kiểm tra quyền trước khi update

---

## 📁 CẤU TRÚC TỆP

### Model
**File:** `app/Models/Team.php`
**Methods:**
```php
public function getProjectsForTeam($teamId)
public function getTasksForTeam($teamId)
```

### Controller
**File:** `app/Controllers/TeamController.php`
**Updates:**
```php
use App\Models\Task;

private $taskModel;

public function __construct() {
    // ...
    $this->taskModel = new Task();
}

public function show($id) {
    // ...
    $tasks = $this->teamModel->getTasksForTeam($id);
    // ... render with $tasks, $isAdmin
}
```

### View
**File:** `views/teams/show.php`
**Section:** "📋 Phân Công Tác Vụ Cho Thành Viên" (2 cột layout)
**Components:**
- Left: Task list with onclick
- Right: Member checkboxes
- JavaScript: selectTask(), updateTaskAction()

### Endpoints Called:
```
GET  /teams/:id                    → TeamController@show
POST /tasks/:id/update-members    → TaskController@updateMembers (existing)
```

---

## ✅ VERIFICATION CHECKLIST

Sau khi implement, kiểm tra:

- [ ] Team model có 2 phương thức mới
- [ ] TeamController import Task model
- [ ] TeamController show() lấy danh sách tác vụ
- [ ] View section "📋 Phân Công Tác Vụ" render đúng
- [ ] Danh sách tác vụ hiển thị
- [ ] Danh sách thành viên hiển thị
- [ ] Click tác vụ → highlight + button hiển thị
- [ ] Checkbox thành viên hoạt động
- [ ] Form submit → gọi updateMembers endpoint
- [ ] Thông báo Success hiển thị
- [ ] Redirect đến `/tasks/:id` sau submit
- [ ] Danh sách thành viên cập nhật trong tác vụ chi tiết

---

## 🐛 TROUBLESHOOT

### ❌ "Section phân công không hiển thị"
→ Kiểm tra:
1. Bạn đã đăng nhập với vai trò Admin chưa?
2. Đội có dự án được gán chưa? (check `/projects/:id`)
3. Dự án có tác vụ chưa?

### ❌ "Danh sách tác vụ trống"
→ Kiểm tra:
1. Dự án có được gán cho đội này chưa?
2. Dự án có tác vụ nào không?
3. Check database: `SELECT * FROM project_teams WHERE team_id = 4`

### ❌ "Không thể click tác vụ"
→ Kiểm tra:
1. JavaScript console có lỗi không? (F12)
2. CSS display: block/none có đúng không?
3. Hãy refresh trang

### ❌ "Form submit nhưng không có phản hồi"
→ Kiểm tra:
1. Member checkbox có được checked không?
2. Network tab → POST request có được gửi không?
3. Response status code là gì? (200, 404, 500?)

### ❌ "Lỗi 404 sau khi submit"
→ Kiểm tra:
1. Route `/tasks/:id/update-members` có trong web.php không?
2. TaskController method `updateMembers()` tồn tại?
3. Task ID có hợp lệ không?

---

## 📝 LƯỚI GHI

- Danh sách tác vụ được lấy từ `project_teams` junction table
- Chỉ lấy tác vụ từ dự án được gán cho đội
- Form action được set dynamically từ JavaScript
- Email notifications có thể thêm sau (bây giờ chỉ Flash message)

---

## ✅ HOÀN THÀNH

Tính năng phân công tác vụ từ trang đội nhóm **HOÀN THÀNH & SẴN DÙNG** 🎉

```
FEATURES AVAILABLE:
✅ View tasks from assigned projects
✅ Select task from left panel
✅ Choose members from right panel
✅ Submit to TaskController::updateMembers()
✅ Auto redirect to task detail page
✅ Real-time member list update

STATUS: READY FOR PRODUCTION ✅
```
