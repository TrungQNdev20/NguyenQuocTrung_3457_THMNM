        </div> <!-- Đóng container mở ở header.php -->
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Cột thông tin công ty -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="text-uppercase mb-3">
                        <i class="bi bi-shop"></i> TechStore
                    </h5>
                    <p class="mb-3">
                        Cửa hàng điện tử hàng đầu với các sản phẩm công nghệ mới nhất.
                        Chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng cao với giá cả hợp lý.
                    </p>
                    <div class="d-flex">
                        <a href="#" class="text-white me-3 fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-3 fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white me-3 fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <!-- Cột liên kết nhanh -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="text-uppercase mb-3">Sản phẩm</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/webbanhang/Product" class="text-white-50 text-decoration-none">Tất cả sản phẩm</a></li>
                        <li class="mb-2"><a href="/webbanhang/Product/add" class="text-white-50 text-decoration-none">Thêm sản phẩm</a></li>
                        <li class="mb-2"><a href="/webbanhang/Product/cart" class="text-white-50 text-decoration-none">Giỏ hàng</a></li>
                    </ul>
                </div>

                <!-- Cột danh mục -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="text-uppercase mb-3">Danh mục</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Điện thoại</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Laptop</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Tablet</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Phụ kiện</a></li>
                    </ul>
                </div>

                <!-- Cột thông tin liên hệ -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="text-uppercase mb-3">Liên hệ</h5>
                    <div class="mb-2">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        123 Đường ABC, Quận XYZ, TP.HCM
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-telephone-fill me-2"></i>
                        +84 123 456 789
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-envelope-fill me-2"></i>
                        info@techstore.com
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-clock-fill me-2"></i>
                        Thứ 2 - Chủ nhật: 8:00 - 22:00
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Dòng bản quyền -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">© 2025 TechStore. Tất cả quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white-50 text-decoration-none me-3">Chính sách bảo mật</a>
                    <a href="#" class="text-white-50 text-decoration-none">Điều khoản sử dụng</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3.6 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
    <script>
        // Hiệu ứng smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Toast notification cho các action
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container') || createToastContainer();
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(container);
            return container;
        }
    </script>
</body>
</html>