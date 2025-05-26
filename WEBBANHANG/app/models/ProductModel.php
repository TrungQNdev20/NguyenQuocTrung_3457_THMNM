<?php
/**
 * ProductModel - Model xử lý dữ liệu sản phẩm
 * Chứa các phương thức CRUD (Create, Read, Update, Delete) cho bảng product
 */
class ProductModel
{
    // Kết nối database
    private $conn;
    // Tên bảng trong database
    private $table_name = "product";

    /**
     * Constructor - Khởi tạo model với kết nối database
     * @param PDO $db - Kết nối database
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy danh sách tất cả sản phẩm kèm tên danh mục
     * Sử dụng LEFT JOIN để lấy cả sản phẩm không có danh mục
     * @return array - Mảng các object sản phẩm
     */
    public function getProducts()
    {
        // Query JOIN với bảng category để lấy tên danh mục
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Trả về tất cả kết quả dưới dạng object
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Lấy thông tin chi tiết một sản phẩm theo ID
     * @param int $id - ID của sản phẩm
     * @return object|false - Object sản phẩm hoặc false nếu không tìm thấy
     */
    public function getProductById($id)
    {
        // Query JOIN để lấy thông tin sản phẩm kèm tên danh mục
        $query = "SELECT p.*, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Trả về một object hoặc false nếu không tìm thấy
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Thêm sản phẩm mới vào database
     * @param string $name - Tên sản phẩm
     * @param string $description - Mô tả sản phẩm
     * @param float $price - Giá sản phẩm
     * @param int $category_id - ID danh mục
     * @param string $image - Đường dẫn hình ảnh
     * @return bool|array - true nếu thành công, array lỗi nếu validation fail
     */
    public function addProduct($name, $description, $price, $category_id, $image)
    {
        // Mảng chứa các lỗi validation
        $errors = [];

        // Kiểm tra validation dữ liệu đầu vào
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        // Nếu có lỗi validation, trả về mảng lỗi
        if (!empty($errors)) {
            return $errors;
        }

        // Câu lệnh SQL INSERT
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image)
                VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu đầu vào để tránh XSS
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        // Bind các tham số vào câu lệnh SQL
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        // Thực thi câu lệnh và trả về kết quả
        if ($stmt->execute()) {
            return true;  // Thành công
        }
        return false;     // Thất bại
    }

    /**
     * Cập nhật thông tin sản phẩm
     * @param int $id - ID sản phẩm cần cập nhật
     * @param string $name - Tên sản phẩm mới
     * @param string $description - Mô tả sản phẩm mới
     * @param float $price - Giá sản phẩm mới
     * @param int $category_id - ID danh mục mới
     * @param string $image - Đường dẫn hình ảnh mới
     * @return bool - true nếu thành công, false nếu thất bại
     */
    public function updateProduct($id, $name, $description, $price, $category_id, $image)
    {
        // Câu lệnh SQL UPDATE
        $query = "UPDATE " . $this->table_name . "
                SET name=:name, description=:description, price=:price, category_id=:category_id, image=:image
                WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu đầu vào để tránh XSS
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        // Bind các tham số vào câu lệnh SQL
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        // Thực thi câu lệnh và trả về kết quả
        if ($stmt->execute()) {
            return true;  // Cập nhật thành công
        }
        return false;     // Cập nhật thất bại
    }

    /**
     * Xóa sản phẩm khỏi database
     * @param int $id - ID sản phẩm cần xóa
     * @return bool - true nếu thành công, false nếu thất bại
     */
    public function deleteProduct($id)
    {
        // Câu lệnh SQL DELETE
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        // Thực thi câu lệnh và trả về kết quả
        if ($stmt->execute()) {
            return true;  // Xóa thành công
        }
        return false;     // Xóa thất bại
    }
}