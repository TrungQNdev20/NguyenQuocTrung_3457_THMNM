<?php
$pageTitle = "Danh sách sản phẩm - TechStore";
include 'app/views/shares/header.php';
?>

<!-- Hero Section -->
<!-- <section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Chào mừng đến với TechStore</h1>
                <p class="lead mb-4">Khám phá những sản phẩm công nghệ mới nhất với giá cả hợp lý. Chúng tôi cam kết mang đến cho bạn trải nghiệm mua sắm tuyệt vời nhất.</p>
                <a href="#products" class="btn btn-light btn-lg">
                    <i class="bi bi-arrow-down"></i> Xem sản phẩm
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-laptop display-1 text-white"></i>
            </div>
        </div>
    </div>
</section> -->

<!-- Products Section -->
<section id="products" class="py-5">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-3">Sản phẩm nổi bật</h2>
                <p class="lead text-muted">Khám phá bộ sưu tập sản phẩm công nghệ đa dạng của chúng tôi</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/webbanhang/Product/add" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
                </a>
            </div>
        </div>

        <!-- Products Grid -->
        <?php if (!empty($products)): ?>
            <div class="row g-4">
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card product-card h-100 shadow-sm">
                            <!-- Product Image -->
                            <div class="position-relative">
                                <?php if ($product->image): ?>
                                    <img src="/webbanhang/<?php echo $product->image; ?>"
                                         class="card-img-top product-image"
                                         alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php else: ?>
                                    <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Category Badge -->
                                <?php if ($product->category_name): ?>
                                    <span class="position-absolute top-0 start-0 badge bg-primary m-2">
                                        <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Product Info -->
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2">
                                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>"
                                       class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h5>

                                <p class="card-text text-muted flex-grow-1">
                                    <?php echo htmlspecialchars(substr($product->description, 0, 100), ENT_QUOTES, 'UTF-8'); ?>
                                    <?php if (strlen($product->description) > 100): ?>...<?php endif; ?>
                                </p>

                                <div class="price-tag mb-3">
                                    <?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>"
                                       class="btn btn-primary">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                                    </a>

                                    <div class="btn-group" role="group">
                                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>"
                                           class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-eye"></i> Xem
                                        </a>
                                        <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>"
                                           class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </a>
                                        <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>"
                                           class="btn btn-outline-danger btn-sm"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                            <i class="bi bi-trash"></i> Xóa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="bi bi-box-seam display-1 text-muted mb-4"></i>
                <h3 class="text-muted mb-3">Chưa có sản phẩm nào</h3>
                <p class="text-muted mb-4">Hãy thêm sản phẩm đầu tiên để bắt đầu bán hàng</p>
                <a href="/webbanhang/Product/add" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Thêm sản phẩm đầu tiên
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>