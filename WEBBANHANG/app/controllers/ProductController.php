<?php
// Require các file cần thiết cho controller
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{

    private $productModel;  
    private $db;  

    public function __construct()
    {
        // Tạo kết nối database
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    /**
     * Hiển thị chi tiết một sản phẩm
     * Route: /Product/show/{id}
     * @param int $id - ID của sản phẩm cần hiển thị
     */
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        // Include view form thêm sản phẩm
        include_once 'app/views/product/add.php';
    }

    public function save()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form, sử dụng ?? để set giá trị mặc định nếu không tồn tại
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;


            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }

    /**
     * Hiển thị form chỉnh sửa sản phẩm
     * Route: /Product/edit/{id}
     * @param int $id - ID của sản phẩm cần chỉnh sửa
     */
    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);

        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    /**
     * Xử lý cập nhật thông tin sản phẩm
     * Route: /Product/update (POST method)
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            // Xử lý upload hình ảnh mới (nếu có)
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                // Nếu không có file mới, giữ nguyên hình ảnh cũ
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    /**
     * Xóa sản phẩm
     * Route: /Product/delete/{id}
     * @param int $id - ID của sản phẩm cần xóa
     */
    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    /**
     * Xử lý upload hình ảnh
     * @param array $file - Thông tin file từ $_FILES
     * @return string - Đường dẫn file đã upload
     * @throws Exception - Nếu có lỗi trong quá trình upload
     */
    private function uploadImage($file)
    {
        // Thư mục lưu trữ file upload
        $target_dir = "uploads/";

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Tạo đường dẫn file đích
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        $allowed_types = ["jpg", "png", "jpeg", "gif"];
        if (!in_array($imageFileType, $allowed_types)) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     * Route: /Product/addToCart/{id}
     * @param int $id - ID của sản phẩm cần thêm vào giỏ hàng
     */
    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        // Khởi tạo giỏ hàng trong session nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        header('Location: /webbanhang/Product/cart');
    }

    /**
     * Hiển thị trang giỏ hàng
     * Route: /Product/cart
     */
    public function cart()
    {
        // Lấy giỏ hàng từ session, nếu không có thì khởi tạo array rỗng
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/Cart.php';
    }

    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Bắt đầu database transaction để đảm bảo tính toàn vẹn dữ liệu
            // Nếu có lỗi xảy ra, tất cả thay đổi sẽ được rollback
            $this->db->beginTransaction();

            try {
                // Bước 1: Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();

                // Lấy ID của đơn hàng vừa tạo
                $order_id = $this->db->lastInsertId();

                // Bước 2: Lưu chi tiết từng sản phẩm trong đơn hàng vào bảng order_details
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                // Bước 3: Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                // Bước 4: Commit transaction - lưu tất cả thay đổi vào database
                $this->db->commit();

                header('Location: /webbanhang/Product/orderConfirmation');

            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    /**
     * Hiển thị trang xác nhận đơn hàng
     * Route: /Product/orderConfirmation
     */
    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }
}
?>