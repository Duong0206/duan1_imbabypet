<?php include('./views/includes/header.php'); ?>

<section>
    <div class="container py-5">
        <h2 class="text-center mb-4">Giỏ Hàng Của Bạn</h2>
        <div class="row">
            <div class="col-md-12">
            <form action="?act=showFormOrder" method="POST" id="checkout-form">
              <table class="table table-bordered table-hover align-middle" style="border-ra">
                  <thead>
                      <tr class=" bg-warning">
                          <th><input type="checkbox" class="select-all" id="select-all"></th>
                          <th scope="col">Sản Phẩm</th>
                          <th scope="col">Hình Ảnh</th>
                          <th scope="col">Đơn Giá</th>
                          <th scope="col">Số Lượng</th>
                          <th scope="col">Tổng</th>
                          <th scope="col">Thao Tác</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php if (!empty($cartDetails)) : ?>
                          <?php foreach ($cartDetails as $item) : ?>
                              <?php $productTotal = $item['DonGia'] * $item['SoLuong']; ?>
                              <tr>
                                  <td>
                                      <input type="checkbox" name="selected_products[]" value="<?= $item['MaSP'] ?>" class="product-checkbox">

                                  </td>
                                  <td>
                                      <div class="d-flex align-items-center">
                                          <span class="ms-3"><?= $item['TenSP'] ?></span>
                                      </div>
                                  </td>
                                  <td>
                                      <img style="width: 100px; height: 100px" src="admin/<?= $item['HinhAnh'] ?>" alt="image" class="img-fluid">
                                  </td>
                                  <td><?= number_format($item['DonGia'], 0, ',', '.') ?> VNĐ</td>
                                  <td>
                                      <div class="d-flex align-items-center">
                                          <button type="button" class="btn btn-secondary btn-decrease btn-sm me-2" data-id="<?= $item['MaSP'] ?>">-</button>
                                                 <span class="quantity-text" style="width: 20px" id="quantity-<?= $item['MaSP'] ?>"><?= $item['SoLuong'] ?></span>
                                                 <input type="hidden" name="product_quantities[<?= $item['MaSP'] ?>]" 
                                                    value="<?= $item['SoLuong'] ?>" class="product-quantity" 
                                                    data-id="<?= $item['MaSP'] ?>" <?= !isset($item['selected']) ? 'disabled' : '' ?>>
                                          <button type="button" class="btn btn-secondary btn-increase btn-sm" data-id="<?= $item['MaSP'] ?>">+</button>
                                      </div>
                                  </td>
                                  <td class="product-total" data-id="<?= $item['MaSP'] ?>">
                                      <?= number_format($productTotal, 0, ',', '.') ?> VNĐ
                                  </td>
                                  <td>
                                      <a class="btn btn-danger btn-remove-item" href="?act=remove-cart&id=<?= $item['MaSP'] ?>" data-id="<?= $item['MaSP'] ?>">Xóa</a>
                                  </td>
                              </tr>
                          <?php endforeach; ?>
                      <?php else : ?>
                          <tr>
                              <td colspan="7" class="text-center">Giỏ hàng trống</td>
                          </tr>
                      <?php endif; ?>
                  </tbody>
              </table>

              <div class="d-flex justify-content-between align-items-center mt-4">
                  <div class="total-price" id="total-price">
                      <?php 
                          $totalPrice = 0;
                          foreach ($cartDetails as $item) {
                              $totalPrice += $item['DonGia'] * $item['SoLuong'];
                          }
                          echo number_format($totalPrice, 0, ',', '.') . ' VNĐ'; 
                      ?>
                  </div>
                  <button type="submit" class="btn btn-warning btn-lg" id="checkout-btn">Tiến Hành Đặt Hàng</button>
              </div>
          </form>
            </div>
        </div>
    </div>
</section>
<?php include('./views/includes/footer.php'); ?>

<script>
document.querySelectorAll('.product-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const productId = this.value;
        const quantityInput = document.querySelector(`input[name="product_quantities[${productId}]"]`);
        
        // Bỏ thuộc tính disabled nếu checkbox được chọn, và ngược lại
        if (this.checked) {
            quantityInput.disabled = false;
        } else {
            quantityInput.disabled = true;
            // Nếu không được chọn, có thể set giá trị mặc định là 0 hoặc xóa giá trị
            quantityInput.value = 0;
        }
    });
});


document.querySelectorAll('.btn-decrease, .btn-increase').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.dataset.id;
        const quantityInput = document.querySelector(`input[name="product_quantities[${productId}]"]`);
        
        // Tăng hoặc giảm số lượng
        let currentQuantity = parseInt(quantityInput.value) || 0;
        if (this.classList.contains('btn-increase')) {
            currentQuantity++;
        } else if (this.classList.contains('btn-decrease') && currentQuantity > 0) {
            currentQuantity--;
        }

        // Cập nhật giá trị trong input
        quantityInput.value = currentQuantity;

        // Cập nhật lại tổng cho sản phẩm
        const totalCell = document.querySelector(`.product-total[data-id="${productId}"]`);
        const productPrice = parseInt(totalCell.dataset.price);
        totalCell.textContent = (currentQuantity * productPrice).toLocaleString() + ' VNĐ';
    });
});

</script>