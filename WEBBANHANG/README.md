# Hệ thống Bán hàng - Web Bán hàng PHP

## Mô tả dự án
Đây là một hệ thống bán hàng đơn giản được xây dựng bằng PHP thuần, sử dụng mô hình MVC (Model-View-Controller). Hệ thống bao gồm các chức năng cơ bản như quản lý sản phẩm, giỏ hàng và đặt hàng.

## Cấu trúc dự án
```
WEBBANHANG/
├── app/
│   ├── config/
│   │   └── database.php          # Cấu hình kết nối database
│   ├── controllers/
│   │   ├── ProductController.php # Controller xử lý sản phẩm
│   │   └── CategoryController.php # Controller xử lý danh mục
│   ├── models/
│   │   ├── ProductModel.php      # Model xử lý dữ liệu sản phẩm
│   │   └── CategoryModel.php     # Model xử lý dữ liệu danh mục
│   └── views/
│       ├── product/              # Views cho sản phẩm
│       └── shares/               # Views dùng chung
├── uploads/                      # Thư mục lưu hình ảnh
├── index.php                     # File chính - routing
├── setup_database.php            # File cập nhật database
└── .htaccess                     # Cấu hình URL rewrite
```

## Chức năng chính

### 1. Quản lý sản phẩm
- **Xem danh sách sản phẩm**: `/Product` hoặc `/Product/index`
- **Xem chi tiết sản phẩm**: `/Product/show/{id}`
- **Thêm sản phẩm mới**: `/Product/add`
- **Chỉnh sửa sản phẩm**: `/Product/edit/{id}`
- **Xóa sản phẩm**: `/Product/delete/{id}`

### 2. Giỏ hàng và đặt hàng
- **Thêm vào giỏ hàng**: `/Product/addToCart/{id}`
- **Xem giỏ hàng**: `/Product/cart`
- **Thanh toán**: `/Product/checkout`
- **Xử lý đặt hàng**: `/Product/processCheckout`
- **Xác nhận đơn hàng**: `/Product/orderConfirmation`

## Cài đặt và chạy dự án

### 1. Yêu cầu hệ thống
- PHP 7.4 trở lên
- MySQL 5.7 trở lên
- Apache/Nginx với mod_rewrite
- Laragon/XAMPP/WAMP (khuyến nghị)

### 2. Cài đặt
1. **Clone hoặc download dự án** vào thư mục web server (ví dụ: `C:\laragon\www\WEBBANHANG`)

2. **Cấu hình database**:
   - Mở file `app/config/database.php`
   - Chỉnh sửa thông tin kết nối database:
   ```php
   private $host = "localhost"; 
   private $db_name = "my_store";     // Tên database
   private $username = "root";        // Username MySQL
   private $password = "";            // Password MySQL
   ```

3. **Tạo database**:
   - Tạo database tên `my_store` trong MySQL
   - Hoặc chạy lệnh SQL: `CREATE DATABASE my_store;`

4. **Cập nhật cấu trúc database**:
   - Truy cập: `http://localhost/webbanhang/setup_database.php`
   - Nhấn nút "Cập nhật Database" để tạo các bảng cần thiết

### 3. Chạy ứng dụng
- Truy cập: `http://localhost/webbanhang/`
- Hệ thống sẽ hiển thị trang danh sách sản phẩm

## Cấu trúc Database

### Bảng `category` (Danh mục)
- `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `name` (VARCHAR(255)) - Tên danh mục
- `description` (TEXT) - Mô tả danh mục
- `created_at`, `updated_at` (TIMESTAMP)

### Bảng `product` (Sản phẩm)
- `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `name` (VARCHAR(255)) - Tên sản phẩm
- `description` (TEXT) - Mô tả sản phẩm
- `price` (DECIMAL(10,2)) - Giá sản phẩm
- `category_id` (INT, FOREIGN KEY) - ID danh mục
- `image` (VARCHAR(500)) - Đường dẫn hình ảnh
- `created_at`, `updated_at` (TIMESTAMP)

### Bảng `orders` (Đơn hàng)
- `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `name` (VARCHAR(255)) - Tên khách hàng
- `phone` (VARCHAR(20)) - Số điện thoại
- `address` (TEXT) - Địa chỉ
- `total_amount` (DECIMAL(10,2)) - Tổng tiền
- `status` (ENUM) - Trạng thái đơn hàng
- `created_at`, `updated_at` (TIMESTAMP)

### Bảng `order_details` (Chi tiết đơn hàng)
- `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `order_id` (INT, FOREIGN KEY) - ID đơn hàng
- `product_id` (INT, FOREIGN KEY) - ID sản phẩm
- `quantity` (INT) - Số lượng
- `price` (DECIMAL(10,2)) - Giá tại thời điểm đặt hàng
- `created_at` (TIMESTAMP)

## Tính năng kỹ thuật

### 1. Routing System
- Sử dụng URL rewrite để tạo URL thân thiện
- Cấu trúc: `/Controller/Action/Param1/Param2/...`
- File `index.php` xử lý routing chính

### 2. MVC Pattern
- **Model**: Xử lý dữ liệu và logic nghiệp vụ
- **View**: Hiển thị giao diện người dùng
- **Controller**: Điều khiển luồng xử lý

### 3. Security Features
- **SQL Injection Prevention**: Sử dụng Prepared Statements
- **XSS Protection**: Sử dụng `htmlspecialchars()` và `strip_tags()`
- **File Upload Security**: Kiểm tra loại file và kích thước
- **Input Validation**: Kiểm tra dữ liệu đầu vào

### 4. Database Transactions
- Sử dụng transaction trong quá trình đặt hàng
- Đảm bảo tính toàn vẹn dữ liệu (ACID)

### 5. Session Management
- Quản lý giỏ hàng qua PHP Session
- Lưu trữ thông tin tạm thời

## Troubleshooting

### Lỗi thường gặp:

1. **"Controller not found"**
   - Kiểm tra file controller có tồn tại không
   - Kiểm tra tên controller có đúng format không

2. **"Connection error"**
   - Kiểm tra thông tin database trong `app/config/database.php`
   - Đảm bảo MySQL đang chạy

3. **Lỗi upload hình ảnh**
   - Kiểm tra quyền ghi thư mục `uploads/`
   - Kiểm tra kích thước file (giới hạn 10MB)

4. **URL không hoạt động**
   - Kiểm tra file `.htaccess`
   - Đảm bảo mod_rewrite được bật

## Phát triển thêm

### Các tính năng có thể bổ sung:
- Hệ thống đăng nhập/đăng ký
- Quản lý người dùng và phân quyền
- Báo cáo thống kê
- Tích hợp thanh toán online
- API REST
- Responsive design
- Tìm kiếm và lọc sản phẩm

## Liên hệ
Nếu có thắc mắc hoặc cần hỗ trợ, vui lòng liên hệ qua email hoặc tạo issue trên repository.
