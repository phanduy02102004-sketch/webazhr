# Hệ Thống Tuyển Dụng Thực Tập Sinh Trực Tuyến - AZ Media (AZHR)

Hệ thống Tuyển dụng & Quản lý Đánh giá Năng lực Thực tập sinh Mini-ATS & Workflow trực tuyến cho Doanh nghiệp AZ Media (Công ty TNHH Đầu tư Phát triển Doanh nghiệp AZ Homes).

---

## 🌟 Các Phân Hệ Chính

### 1. Phân hệ Ứng viên (Careers & Candidate Portal)
- **Careers Landing Page (`/` hoặc `/careers`):** Giới thiệu văn hóa công ty, chế độ đãi ngộ, môi trường "Thầy giỏi - Bạn tốt - Sách hay", triết lý AZ Media và danh sách các vị trí tuyển dụng thực tập sinh đang mở (lọc theo Chuyên ngành, Hình thức, Địa điểm).
- **Nộp hồ sơ trực tuyến (`/careers` modal):** Ứng viên điền thông tin, chọn vị trí (hoặc tự điền vị trí khác), tải lên CV PDF.
- **Quy trình Đánh giá Năng lực 4 phần (`/candidate/test/{code}`):**
  1. *Phần 1: Đánh giá Năng lực & Tính cách (NLB / NLP, DISC, MBTI, Thần số học đường đời).*
  2. *Phần 2: Bánh xe cuộc đời (Đánh giá mức độ hài lòng trên thang điểm 1-10).*
  3. *Phần 3: Hoài bão, Động cơ & Kế hoạch phát triển bản thân (Cam kết, tự luận).*
  4. *Phần 4: Hiểu biết về Văn hóa & Doanh nghiệp AZ Media (Trắc nghiệm + Tự luận cảm nhận).*
- **Xuất PDF Bài Test:** Hệ thống tự động biên dịch kết quả bài test thành file PDF hoàn chỉnh chuẩn báo cáo cho Admin/Mentor đánh giá.
- **Tra cứu kết quả hồ sơ (`/candidate/track`):** Tra cứu theo mã ứng viên hoặc email.

### 2. Phân hệ Quản trị Tuyển dụng (Mini-ATS & Workflow)
- **Đăng nhập quản trị (`/portal/login`):**
  - Tài khoản mặc định: `admin@gmail.com` / `123456789` hoặc `admin@azmedia.com.vn` / `123456789`
- **Dashboard & Analytics (`/portal/dashboard`):** Thống kê số lượng vị trí tuyển, ứng viên đã nộp, ứng viên đã hoàn thành test, tỷ lệ đạt/trúng tuyển.
- **Quản lý Ứng viên (`/portal/applications` & `/portal/kanban`):**
  - Pipeline trạng thái: Mới nộp ➔ Đã làm test ➔ Đã duyệt hồ sơ ➔ Hẹn phỏng vấn ➔ Đạt/Mời nhận việc ➔ Từ chối.
  - Xem chi tiết hồ sơ, mở xem CV trực tuyến, xem/tải file PDF bài test trực tiếp.
  - Phân công Mentor phỏng vấn (Admin, Lê Đình Quang, Người phụ trách tự điền tên).
  - Tự động gửi Email thông báo kết quả / lịch phỏng vấn với các biến động `{candidate_name}`, `{position_title}`, `{interview_time}`, `{interview_location}`, `{mentor_name}`.
- **Quản lý Vị trí Tuyển dụng (`/portal/positions`):** Thêm, sửa, xóa, bật/tắt trạng thái mở tuyển.
- **Ngân hàng Đề Test (`/portal/questions`):** Quản lý câu hỏi trắc nghiệm, thêm mới, sửa câu hỏi và đáp án, xóa câu hỏi.

---

## 🛠️ Yêu Cầu Cài Đặt & Môi Trường

- **PHP:** >= 8.1 (khuyên dùng PHP 8.2)
- **Web Server:** Apache (XAMPP) hoặc `php artisan serve`
- **Database:** MySQL / MariaDB (XAMPP)
- **Composer** & **Node.js**

---

## 🚀 Hướng Dẫn Cài Đặt Nhanh

### 1. Clone dự án
```bash
git clone https://github.com/phanduy02102004-sketch/webazhr.git
cd webazhr
```

### 2. Cài đặt thư viện
```bash
composer install
```

### 3. Cấu hình cơ sở dữ liệu (.env)
Sao chép file `.env.example` thành `.env`:
```bash
cp .env.example .env
php artisan key:generate
```
Cấu hình thông số MySQL trong file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laptrinhwebnangcao
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Import Cơ Sở Dữ Liệu
Cơ sở dữ liệu hoàn chỉnh đã được xuất sẵn tại file **`webazhr.sql`** (và `database/webazhr.sql`).
- Mở **phpMyAdmin** (`http://localhost/phpmyadmin`).
- Tạo cơ sở dữ liệu mới có tên: **`laptrinhwebnangcao`**.
- Chọn tab **Import** và chọn file **`webazhr.sql`** rồi bấm **Go / Thực hiện**.

Hoặc import qua dòng lệnh MySQL:
```bash
mysql -u root -p laptrinhwebnangcao < webazhr.sql
```

### 5. Khởi chạy máy chủ
```bash
php artisan serve
```
Truy cập:
- **Trang chủ tuyển dụng:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Trang quản trị ATS:** [http://127.0.0.1:8000/portal](http://127.0.0.1:8000/portal)
