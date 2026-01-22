# 📋 TỔNG HỢP CÁC FILE UPDATE - TÍNH NĂNG FAKE ENGAGEMENT

## 🎯 Mục đích
Tự động tạo fake reactions cho bài viết của admin, tăng dần theo lượt xem (max 5% views), mỗi bài có số lượng khác nhau.

---

## 📁 CÁC FILE ĐÃ TẠO/SỬA

### 1. **File SQL - Tạo bảng và cài đặt**
📄 `Script/fake_engagement.sql`
- Tạo bảng `posts_fake_reactions`
- Thêm cài đặt vào `system_options`
- **Cần chạy file này trước!**

### 2. **Class chính - Xử lý logic**
📄 `Script/includes/class-fake-engagement.php` (FILE MỚI)
- Class `FakeEngagement` với các phương thức:
  - `get_real_users()` - Lấy users đủ điều kiện
  - `mark_admin_post()` - Đánh dấu bài viết admin
  - `calculate_fake_count()` - Tính số fake reactions (1-5% views)
  - `update_fake_reactions_by_views()` - Cập nhật fake khi có views
  - `update_post_reaction_counts()` - Cộng real + fake vào counter
  - `remove_from_fake()` - Xóa user khỏi fake khi react thật
  - Và nhiều hàm hỗ trợ khác

### 3. **Bootstrap - Load class**
📄 `Script/bootstrap.php`
**Thêm dòng:**
```php
// fake engagement
require_once(ABSPATH . 'includes/class-fake-engagement.php');
```

### 4. **Class User - Tích hợp tính năng**
📄 `Script/includes/class-user.php`

#### 4.1. Hàm `publisher()` - Khi admin đăng bài (dòng ~6047)
```php
/* fake engagement - đánh dấu bài viết admin (fake reactions sẽ tăng dần theo views) */
if (isset($system['fake_engagement_enabled']) && $system['fake_engagement_enabled']) {
  if (FakeEngagement::is_admin($this->_data['user_id'])) {
    FakeEngagement::mark_admin_post($post['post_id'], $this->_data['user_id']);
  }
}
```

#### 4.2. Hàm `get_post()` - Khi có người xem bài (dòng ~6918)
```php
/* fake engagement - tăng dần theo views cho bài viết của admin */
if (isset($system['fake_engagement_enabled']) && $system['fake_engagement_enabled']) {
  if (FakeEngagement::is_marked_post($post['post_id'])) {
    $new_views = $post['views'] + 1;
    FakeEngagement::update_fake_reactions_by_views($post['post_id'], $post['author_id'], $new_views);
  }
}
```

#### 4.3. Hàm `who_reacts()` - Hiển thị danh sách reactions (dòng ~6972)
- Lấy real reactions trước
- Lấy fake reactions (loại trừ viewer và real reactors)
- Tránh trùng lặp user

#### 4.4. Hàm `react_post()` - Khi user react thật (dòng ~8594)
```php
/* remove from fake reactions if user is in fake list (before real react) */
$was_fake_reactor = FakeEngagement::is_fake_reactor($post_id, $this->_data['user_id']);
if ($was_fake_reactor) {
  FakeEngagement::remove_from_fake($post_id, $this->_data['user_id']);
}

// ... insert real reaction ...

/* update post reaction counter - cập nhật lại tổng (real + fake) */
FakeEngagement::update_post_reaction_counts($post_id);
```

#### 4.5. Hàm `unreact_post()` - Khi user bỏ react (dòng ~8638)
```php
/* update post reaction counter - cập nhật lại tổng (real + fake) */
FakeEngagement::update_post_reaction_counts($post_id);
```

---

## ⚙️ CÁCH HOẠT ĐỘNG

### 1. **Khi admin đăng bài:**
- Đánh dấu bài viết (marker với `user_id = 0`)
- **Chưa có fake reactions**

### 2. **Khi có người xem bài:**
- Tính số fake cần có: `views × (1-5%)` (mỗi bài có % riêng)
- Không vượt quá số users có sẵn
- Thêm fake reactions nếu cần

### 3. **Khi user react thật:**
- Nếu user có trong fake list → xóa khỏi fake
- Cập nhật counter (real + fake)

### 4. **Khi user xem danh sách reactions:**
- Hiển thị real reactions
- Hiển thị fake reactions (loại trừ viewer)
- Không trùng lặp

---

## 📊 ĐIỀU KIỆN USER ĐƯỢC CHỌN

✅ Có ảnh đại diện (`user_picture`)
✅ Có ảnh bìa (`user_cover`)
✅ Có số điện thoại (`user_phone`)
❌ **Không cần kích hoạt** (đã bỏ điều kiện `user_activated`)

---

## 🎲 TỶ LỆ REACTIONS

| Reaction | Tỷ lệ |
|----------|-------|
| Like | 45% |
| Love | 30% |
| Haha | 15% |
| Wow | 8% |
| Sad | 1% |
| Angry | 1% |

---

## 📈 VÍ DỤ TÍNH TOÁN

Với **78 users** đủ điều kiện:

| Views | % riêng (1-5%) | Fake reactions |
|-------|----------------|----------------|
| 100 | 3% | min(3, 78) = **3** |
| 500 | 5% | min(25, 78) = **25** |
| 1000 | 2% | min(20, 78) = **20** |
| 2000 | 4% | min(80, 78) = **78** (max users) |

---

## 🔧 QUẢN LÝ

### Bật/Tắt tính năng:
```sql
-- Tắt
UPDATE system_options SET option_value = '0' WHERE option_name = 'fake_engagement_enabled';

-- Bật
UPDATE system_options SET option_value = '1' WHERE option_name = 'fake_engagement_enabled';
```

### Xóa tất cả fake reactions:
```sql
DELETE FROM posts_fake_reactions WHERE user_id > 0;
```

---

## ✅ CHECKLIST TRIỂN KHAI

- [x] Chạy file `fake_engagement.sql`
- [x] File `class-fake-engagement.php` đã tạo
- [x] `bootstrap.php` đã require class
- [x] `class-user.php` đã tích hợp 5 điểm:
  - [x] `publisher()` - Đánh dấu bài admin
  - [x] `get_post()` - Tăng fake theo views
  - [x] `who_reacts()` - Hiển thị danh sách
  - [x] `react_post()` - Xử lý react thật
  - [x] `unreact_post()` - Xử lý unreact

---

## 🐛 LƯU Ý

1. **Marker records**: `user_id = 0` và `reaction = 'marker'` là đánh dấu, không phải fake reaction
2. **Tránh trùng lặp**: User không thể vừa có real vừa có fake reaction
3. **Counter luôn đúng**: Mỗi lần react/unreact đều cập nhật lại tổng (real + fake)

---

## 📝 GHI CHÚ

- Fake reactions tăng dần theo views, không tạo ngay khi đăng
- Mỗi bài viết có tỷ lệ riêng (1-5%) dựa trên `post_id`
- User xem danh sách reactions không thấy chính mình trong fake
- Nếu user react thật, tự động xóa khỏi fake list

---

**Ngày tạo:** 2026-01-21  
**Phiên bản:** 1.0
