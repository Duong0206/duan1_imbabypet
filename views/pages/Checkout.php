<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Giỏ hàng của bạn đang trống!'); window.location.href='index.php?act=cart';</script>";
    exit;
}

$cart = $_SESSION['cart'];

// Tính tổng tiền
$TongTien = 0;
foreach ($cart as $item) {
    $TongTien += $item['DonGia'] * $item['SoLuong'];
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="path/to/your/css/file.css"> <!-- Đường dẫn CSS -->
</head>
<body>
    <h1>Thanh Toán</h1>

    <h2>Giỏ Hàng Của Bạn</h2>
    <table>
        <thead>
            <tr>
                <th>Tên Sản Phẩm</th>
                <th>Số Lượng</th>
                <th>Đơn Giá</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $item): ?>
            <tr>
                <td><?= $item['TenSP'] ?></td>
                <td><?= $item['SoLuong'] ?></td>
                <td><?= number_format($item['DonGia'], 0, ',', '.') ?> VND</td>
                <td><?= number_format($item['DonGia'] * $item['SoLuong'], 0, ',', '.') ?> VND</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Thông tin người đặt</h2>
    <form action="">
        // thêm thông tin người đặt vào đ
    </form>

    <h3>Tổng Tiền: <?= number_format($TongTien, 0, ',', '.') ?> VND</h3>

    <form action="index.php?act=checkout" method="post">
        <button type="submit">Xác Nhận Đặt Hàng</button>
    </form>

    <a href="index.php?act=cart">Quay lại giỏ hàng</a>
</body>
</html>
