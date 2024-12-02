<?php include('./views/includes/header.php'); ?>

<section>
    <div class="container py-5">
        <h2 class="text-center mb-4">Danh Sách Đơn Hàng</h2>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr class="bg-warning">
                            <th scope="col">STT</th>
                            <th scope="col">Mã Đơn Hàng</th>
                            <th scope="col">Ngày Đặt</th>
                            <th scope="col">Ngày Giao</th>
                            <th scope="col">Tình Trạng</th>
                            <th scope="col">Tổng Tiền</th>
                            <th scope="col">Chi Tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)) : ?>
                            <?php foreach ($orders as $index => $order) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $order['MaDH'] ?></td>
                                    <td><?= $order['NgayDat'] ?></td>
                                    <td><?= $order['NgayGiao'] ?? 'Chưa cập nhật' ?></td>
                                    <td>
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
                                                    echo "Pending";
                                            }
                                        ?>
                                    </td>
                                    <td><?= number_format($order['TongTien'], 0, ',', '.') ?> VNĐ</td>
                                    <td>
                                        <a href="?act=viewOrderDetail&MaDH=<?= $order['MaDH'] ?>" class="btn btn-info btn-sm">Xem</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center">Không có đơn hàng nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include('./views/includes/footer.php'); ?>
