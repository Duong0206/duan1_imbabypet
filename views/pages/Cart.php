<?php include('./views/includes/header.php'); ?>

<section>
    <div class="container py-5">
        <h2 class="text-center mb-4">Giỏ Hàng Của Bạn</h2>
        <div class="row">
            <div class="col-md-12">
                <form action="update-cart.php" method="POST" id="cart-form">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="select-all"></th>
                                <th scope="col">Sản Phẩm</th>
                                <th scope="col">Hình Ảnh</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col">Tổng</th>
                                <th scope="col">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Kiểm tra xem giỏ hàng có tồn tại và không trống không
                            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                // Duyệt qua từng sản phẩm trong giỏ hàng
                                foreach ($_SESSION['cart'] as $item) {
                                    // Tính tổng tiền của sản phẩm
                                    $productTotal = $item['DonGia'] * $item['SoLuong'];
                                    echo "<tr>
                                        <td><input type='checkbox' name='product_ids[]' value='{$item['MaSP']}' class'product-checkbox'></td>
                                        <td>
                                            <div class='d-flex align-items-center'>
                                                <span class='ms-3'>{$item['TenSP']}</span>
                                            </div>
                                        </td>
                                        <td><img style='width: 100px; height: 100px' src='admin/{$item['HinhAnh']}' alt='image' class='img-fluid'></td>
                                        <td>{$item['DonGia']} VNĐ</td>
                                        <td>
                                            <input type='number' class='form-control update-quantity' data-id='{$item['MaSP']}' value='{$item['SoLuong']}' min='1'>
                                        </td>
                                        <td class='product-total' data-id='{$item['MaSP']}'>" . number_format($productTotal) . " VNĐ</td>
                                        <td>
                                            <a class='btn btn-danger' href='?act=remove-cart&id={$item['MaSP']}'>Xóa</a>
                                        </td>
                                
                                    </tr>";
                                }
                            } else {
                                // Giỏ hàng trống
                                echo "<tr><td colspan='5' class='text-center'>Giỏ hàng trống</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <?php
                        // Tính tổng giỏ hàng
                        $totalPrice = 0;
                        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                $totalPrice += $item['DonGia'] * $item['SoLuong'];
                            }
                        }
                        ?>
                        <div class="total-price" id="total-price"><?php echo number_format($totalPrice); ?> VNĐ</div>
                        <!-- <button type="submit" class="btn btn-primary">Cập Nhật Giỏ Hàng</button> -->
                        <a href="?act=showCheckout" class="btn btn-success btn-lg">Tiến Hành Thanh Toán</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


  <!-- <section id="clothing" class="my-5 overflow-hidden">
    <div class="container pb-5">

      

      <div class="products-carousel swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item1.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                    
                  </div>


                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item2.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                   
                  </div>

                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item3.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                    
                  </div>


                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item4.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                    
                  </div>


                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item7.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                   
                  </div>


                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item8.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                    
                  </div>


                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section> -->

    <?php include('./views/includes/footer.php') ?>




    <script>
    // Xóa sản phẩm khỏi giỏ hàng
    document.querySelectorAll('.btn-remove-item').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                //trả về router phương thức remove-cart
                window.location.href = `remove-cart.php?id=${id}`;

            }
        });
    });

    // Cập nhật số lượng sản phẩm trong giỏ hàng qua AJAX
    document.querySelectorAll('.update-quantity').forEach(input => {
        input.addEventListener('change', function () {
            const productId = this.getAttribute('data-id');
            const newQuantity = parseInt(this.value);

            // Gửi yêu cầu AJAX để cập nhật giỏ hàng
            fetch('update-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: productId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật giá sản phẩm và tổng giỏ hàng trên giao diện
                    this.closest('tr').querySelector('.product-total').innerText = data.productTotal + ' VNĐ';
                    document.getElementById('total-price').innerText = data.cartTotal + ' VNĐ';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

<script>
    document.getElementById('select-all').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    document.getElementById('checkout-form').addEventListener('submit', function (e) {
        const checkboxes = document.querySelectorAll('.product-checkbox:checked');
        if (checkboxes.length === 0) {
            e.preventDefault();
            alert('Hãy lựa chọn sản phẩm trước khi tiến hành thanh toán!');
        }
    });
</script>