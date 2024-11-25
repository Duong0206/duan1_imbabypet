<?php
session_start(); // Đảm bảo khởi tạo session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ yêu cầu AJAX
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['id']; // ID sản phẩm
    $newQuantity = $input['quantity']; // Số lượng mới

    // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
    if (isset($_SESSION['cart'][$productId])) {
        // Cập nhật số lượng sản phẩm
        $_SESSION['cart'][$productId]['SoLuong'] = $newQuantity;
    }

    // Tính lại tổng tiền cho sản phẩm và giỏ hàng
    $productTotal = $_SESSION['cart'][$productId]['DonGia'] * $newQuantity;
    $cartTotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cartTotal += $item['DonGia'] * $item['SoLuong'];
    }

    // Trả về kết quả dưới dạng JSON
    echo json_encode([
        'success' => true,
        'productTotal' => $productTotal,
        'cartTotal' => $cartTotal
    ]);
    exit;
}
?>
