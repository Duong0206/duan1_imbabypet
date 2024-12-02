<?php include('./views/includes/header.php'); ?>

<section>
    <div class="container py-5 mb-5">
    <a href="index.php?act=cart" class="btn btn-primary btn-sm">Quay lại giỏ hàng</a>

        <h2 class="text-center mb-4">Thanh Toán</h2>

        <div class="row">
            <article class="col-lg-6" style="width: 70%">
            <form action="#" method="POST" id="order-form">
                    <table class="table table-bordered align-middle" style="border-radius: 20px">
                        <thead>
                            <tr class=" bg-warning">
                                <th scope="col">Sản Phẩm</th>
                                <th scope="col">Hình Ảnh</th>
                                <th scope="col">Đơn Giá</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col">Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($productDetails)) : ?>
                                <?php foreach ($productDetails as $item) : ?>
                                    <tr>
                                        <td><?= $item['TenSP'] ?></td>
                                        <td>
                                            <img style="width: 100px; height: 100px" src="admin/<?= $item['HinhAnh'] ?>" alt="image" class="img-fluid">
                                        </td>
                                        <td><?= number_format($item['DonGiaBan'], 0, ',', '.') ?> VNĐ</td>
                                        <td><?php echo $item['SoLuong']; ?></td>
                                        <td><?= number_format($item['DonGiaBan'], 0, ',', '.') ?> VNĐ</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Không có sản phẩm nào để thanh toán</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <!-- <h3>Tổng tiền: <?= number_format($totalAmount, 0, ',', '.') ?> VNĐ</h3> -->

                </form>
            </article>
            <aside class="col-lg-6" style="width: 30%;">
                <form action="?act=processPayment" method="POST" class="bg-warning p-3" style=" border-radius: 10px;">

                                    <!-- Truyền các sản phẩm đã chọn -->
                    <input type="hidden" name="selected_products[]" value="<?= $item['MaSP'] ?>">
                    <input type="hidden" name="product_quantities[<?= $item['MaSP'] ?>]" value="<?= $item['SoLuong'] ?>">
                    <input type="hidden" name="total_amount" value="<?= $totalAmount ?>">

                    <div class="mb-3">
                        <label for="HoTen" class="form-label">Tên Người Nhận</label>
                        <input type="text" class="form-control" id="HoTen" name="HoTen">
                        <span class="text-danger" id="errorHoTen"></span>
                    </div>
                    <div class="mb-3">
                        <label for="DienThoai" class="form-label">Số Điện Thoại Người Nhận</label>
                        <input type="phone" class="form-control" id="DienThoai" name="DienThoai">
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email">
                    </div>
                    <div class="mb-3">
                        <label for="DiaChi" class="form-label">Địa chỉ người nhận</label>
                        <input type="text" class="form-control" id="DiaChi" name="DiaChi">
                    </div>
                    <div class="mb-3">
                        <label for="PhuongThucThanhToan" class="form-label">Phương thức thanh toán:</label>
                        <select name="PhuongThucThanhToan" id="" class="form-control w-100 ">
                            <option value="">--chọn phương thức thanh toán--</option>
                            <option value="cod">Thanh toán khi nhận hàng</option>
                            <option value="online">Thanh toán online</option>
                            
                        </select>
                    </div>
                    <h3>Tổng tiền: <?= number_format($totalAmount, 0, ',', '.') ?> VNĐ</h3>


                    <button type="submit" class="btn btn-success w-100 ">Thanh Toán</button>
                </form>
            </aside>
        </div>
    </div>
</section>

<?php include('./views/includes/footer.php'); ?>
