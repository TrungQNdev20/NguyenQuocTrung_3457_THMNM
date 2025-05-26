<?php
/**
 * File index.php - Entry point chính của ứng dụng
 * Xử lý routing và điều hướng request đến controller/action tương ứng
 *
 * Cấu trúc URL: /Controller/Action/Param1/Param2/...
 * Ví dụ: /Product/show/1 -> ProductController->show(1)
 */

// Khởi tạo session để lưu trữ dữ liệu giỏ hàng và thông tin user
session_start();

// Require model cần thiết (có thể bỏ dòng này vì đã require trong controller)
require_once 'app/models/ProductModel.php';

/**
 * PHẦN XỬ LÝ ROUTING
 * Phân tích URL để xác định controller và action cần gọi
 */

// Lấy URL từ parameter, nếu không có thì để trống
$url = $_GET['url'] ?? '';

// Loại bỏ dấu / ở cuối URL (nếu có)
$url = rtrim($url, '/');

// Làm sạch URL để tránh các ký tự độc hại
$url = filter_var($url, FILTER_SANITIZE_URL);

// Tách URL thành mảng các phần tử, phân cách bởi dấu /
$url = explode('/', $url);

/**
 * XÁC ĐỊNH CONTROLLER
 * Phần đầu tiên của URL sẽ là tên controller
 * Nếu không có hoặc rỗng thì mặc định là ProductController
 */
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'ProductController';

/**
 * XÁC ĐỊNH ACTION (METHOD)
 * Phần thứ hai của URL sẽ là tên action/method
 * Nếu không có hoặc rỗng thì mặc định là 'index'
 */
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Debug line - có thể uncomment để kiểm tra routing
// die ("controller=$controllerName - action=$action");

/**
 * KIỂM TRA VÀ LOAD CONTROLLER
 */
// Kiểm tra xem file controller có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Nếu không tìm thấy controller, hiển thị lỗi và dừng
    die('Controller not found');
}

// Include file controller
require_once 'app/controllers/' . $controllerName . '.php';

// Tạo instance của controller
$controller = new $controllerName();

/**
 * KIỂM TRA VÀ GỌI ACTION
 */
// Kiểm tra xem method/action có tồn tại trong controller không
if (!method_exists($controller, $action)) {
    // Nếu không tìm thấy action, hiển thị lỗi và dừng
    die('Action not found');
}

/**
 * THỰC THI ACTION VỚI CÁC THAM SỐ
 * Gọi method của controller với các tham số từ URL (nếu có)
 * array_slice($url, 2) sẽ lấy tất cả phần tử từ vị trí thứ 3 trở đi làm tham số
 * Ví dụ: /Product/show/1/edit -> gọi ProductController->show(1, 'edit')
 */
call_user_func_array([$controller, $action], array_slice($url, 2));