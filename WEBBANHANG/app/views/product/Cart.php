<?php
$pageTitle = "Giỏ hàng - TechStore";
include 'app/views/shares/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-cart3"></i> Giỏ hàng của bạn
                </h2>
                <?php if (!empty($cart)): ?>
                    <span class="badge bg-primary fs-6"><?php echo count($cart); ?> sản phẩm</span>
                <?php endif; ?>
            </div>

            <?php if (!empty($cart)): ?>
                <?php
                $total = 0;
                foreach ($cart as $id => $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Product Image -->
                                <div class="col-md-2">
                                    <?php if ($item['image']): ?>
                                        <img src="/webbanhang/<?php echo $item['image']; ?>"
                                             class="img-fluid rounded"
                                             alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                             style="max-height: 80px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Product Info -->
                                <div class="col-md-4">
                                    <h5 class="card-title mb-1">
                                        <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </h5>
                                    <p class="text-muted mb-0">
                                        <small>Đơn giá: <?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</small>
                                    </p>
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center">
                                        <label class="form-label me-2 mb-0">Số lượng:</label>
                                        <div class="input-group" style="width: 120px;">
                                            <button class="btn btn-outline-secondary btn-sm" type="button">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="text" class="form-control form-control-sm text-center"
                                                   value="<?php echo $item['quantity']; ?>" readonly>
                                            <button class="btn btn-outline-secondary btn-sm" type="button">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subtotal & Actions -->
                                <div class="col-md-3 text-end">
                                    <div class="fw-bold text-primary mb-2">
                                        <?php echo number_format($subtotal, 0, ',', '.'); ?> VNĐ
                                    </div>
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <!-- Empty Cart -->
                <div class="text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Giỏ hàng của bạn đang trống</h3>
                    <p class="text-muted mb-4">Hãy thêm một số sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                    <a href="/webbanhang/Product" class="btn btn-primary btn-lg">
                        <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Order Summary -->
        <?php if (!empty($cart)): ?>
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-receipt"></i> Tóm tắt đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-primary fs-5"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</strong>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="/webbanhang/Product/checkout" class="btn btn-primary btn-lg">
                                <i class="bi bi-credit-card"></i> Thanh toán
                            </a>
                            <a href="/webbanhang/Product" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Promo Code -->
                <!-- <div class="card mt-3 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-tag"></i> Mã giảm giá
                        </h6>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Nhập mã giảm giá">
                            <button class="btn btn-outline-primary" type="button">Áp dụng</button>
                        </div>
                    </div>
                </div> -->
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>