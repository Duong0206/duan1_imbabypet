<?php include('./views/includes/header.php'); ?>

<section>
    <div class="container py-5">
        <h2 class="text-center mb-4">Chi Tiết Đơn Hàng #<?= $order['MaDH'] ?></h2>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr class="bg-warning">
                            <th scope="col">STT</th>
                            <th scope="col">Mã Sản Phẩm</th>
                            <th scope="col">Tên Sản Phẩm</th>
                            <th scope="col">Số Lượng</th>
                            <th scope="col">Đơn Giá</th>
                            <th scope="col">Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orderDetails)) : ?>
                            <?php foreach ($orderDetails as $index => $detail) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $detail['MaSP'] ?></td>
                                    <td><?= $detail['TenSP'] ?></td>
                                    <td><?= $detail['SoLuong'] ?></td>
                                    <td><?= number_format($detail['DonGia'], 0, ',', '.') ?> VNĐ</td>
                                    <td><?= number_format($detail['ThanhTien'], 0, ',', '.') ?> VNĐ</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có sản phẩm trong đơn hàng này</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Thông Tin Khách Hàng</h4>
                <p><strong>Họ Tên:</strong> <?= $customer['HoTen'] ?></p>
                <p><strong>Địa Chỉ:</strong> <?= $customer['DiaChi'] ?></p>
                <p><strong>Điện Thoại:</strong> <?= $customer['DienThoai'] ?></p>
                <p><strong>Email:</strong> <?= $customer['Email'] ?></p>
            </div>

            <div class="col-md-6">
                <h4>Thông Tin Đơn Hàng</h4>
                <p><strong>Ngày Đặt:</strong> <?= $order['NgayDat'] ?></p>
                <p><strong>Ngày Giao Dự Kiến:</strong> <?= $order['NgayGiao'] ?? 'Chưa cập nhật' ?></p>
                <p><strong>Tình Trạng:</strong> 
                    <?php
                        switch ($order['TinhTrangDH']) {
                            case 'pending':
                                echo "Chờ xử lý";
                                break;
                            case 'shipping':
                                echo "Đang giao";
                                break;
                            case 'delivered':
                                echo "Hoàn thành";
                                break;
                            case 'cancel':
                                echo "Đã Hủy";
                            default:
                                echo "Chưa xác định";
                        }
                    ?>
                </p>
                <p><strong>Tổng Tiền:</strong> <?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</p>
            </div>
        </div>
        
        <!-- Nút huỷ đơn hàng -->
        <?php if ($order['TinhTrangDH'] == 'pending') : ?>
            <form action="index.php?act=cancelOrder&MaDH=<?= $order['MaDH'] ?>" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn huỷ đơn hàng này?');">
                <button type="submit" class="btn btn-danger">Huỷ Đơn Hàng</button>
            </form>
        <?php endif; ?>

        <div class="mt-4">
            <a href="index.php?act=listOrders" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
        </div>
    </div>
</section>

<?php include('./views/includes/footer.php'); ?>
