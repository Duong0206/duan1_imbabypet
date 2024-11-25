<?php 

    require_once './models/ProductModel.php';
    // require_once './models/CategoryModel.php';
    require_once './commons/helper.php';

class HomeController
{
    public $productModel;
    function __construct()
    {
        $this->productModel = new ProductModel();
        
    }
    public function index()
    {
        $products = $this->productModel->getAllProducts();
        // $categories = $this->productModel->getAllCategories();
        require_once "home.php";
    }

    public function productDetail($MaSP){
        $MaSP = $_GET['MaSP'] ?? null;
        $product = $this->productModel->getProductByID($MaSP);
        require_once "./views/pages/ProductDetail.php";
    }

    public function cart(){
        if(!isset($_SESSION['MaAdmin'])){
            echo "<script>alert('Vui lòng đăng nhập để truy cập giỏ hàng!'); window.location.href='index.php?act=showLogin';</script>";
            exit;

        }

        require_once "./views/pages/Cart.php";
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['MaAdmin'])) {
            echo "<script>alert('Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng!'); window.location.href='index.php?act=showLogin';</script>";
            exit;
        }

        $MaSP = $_GET['MaSP'] ?? null;
        $SoLuong = $_GET['SoLuong'] ?? 1;

        if (!$MaSP) {
            echo "<script>alert('Sản phẩm không hợp lệ!'); window.history.back();</script>";
            exit;
        }

        $product = $this->productModel->getProductByID($MaSP);

        if (!$product) {
            echo "<script>alert('Không tìm thấy sản phẩm!'); window.history.back();</script>";
            exit;
        }

        $DonGia = $product['DonGiaBan'];

        // Thêm sản phẩm vào giỏ hàng
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$MaSP])) {
            $_SESSION['cart'][$MaSP]['SoLuong'] += $SoLuong;
        } else {
            $_SESSION['cart'][$MaSP] = [
                'MaSP' => $MaSP,
                'TenSP' => $product['TenSP'],
                'SoLuong' => $SoLuong,
                'DonGia' => $DonGia,
                'HinhAnh' => $product['HinhAnh']
            ];
        }

        echo "<script>alert('Thêm sản phẩm vào giỏ hàng thành công!'); window.location.href='index.php?act=cart';</script>";
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeCart()
    {
        $productId = $_GET['id'] ?? null;

        if ($productId && isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        header('Location: index.php?act=cart');
        exit;
    }


    function updateCart(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $productId = $input['id'] ?? null;
            $newQuantity = $input['quantity'] ?? 0;

            if ($productId && isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['SoLuong'] = $newQuantity;
            }

            // Tính tổng tiền
            $productTotal = $_SESSION['cart'][$productId]['DonGia'] * $newQuantity;
            $cartTotal = array_reduce($_SESSION['cart'], function ($sum, $item) {
                return $sum + $item['DonGia'] * $item['SoLuong'];
            }, 0);

            echo json_encode([
                'success' => true,
                'productTotal' => $productTotal,
                'cartTotal' => $cartTotal
            ]);
            exit;
        }

    }

    function showCheckout(){
        require_once "./views/pages/Checkout.php";
    }

    function checkout(){
        // Kiểm tra nếu giỏ hàng rỗng
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<script>alert('Giỏ hàng của bạn đang trống!'); window.location.href='index.php?act=cart';</script>";
            exit;
        }

        // Lấy thông tin giỏ hàng từ session
        $cart = $_SESSION['cart'];



        // Tính tổng tiền
        $TongTien = 0;
        foreach ($cart as $item) {
            $TongTien += $item['DonGia'] * $item['SoLuong'];
        }

        // // Lưu đơn hàng vào cơ sở dữ liệu
        // $MaDH = $this->$productModel->createOrder($MaKH, $TongTien);

        // if ($MaDH) {
        //     // Lưu chi tiết đơn hàng
        //     foreach ($cart as $item) {
        //         $productModel->addOrderDetail($MaDH, $item['MaSP'], $item['SoLuong'], $item['DonGia']);
        //     }
    
        //     // Xóa giỏ hàng
        //     unset($_SESSION['cart']);
    
        //     // Điều hướng đến trang chi tiết đơn hàng
        //     echo "<script>alert('Thanh toán thành công!'); window.location.href='index.php?act=orderDetail&MaDH=$MaDH';</script>";
        // } else {
        //     echo "<script>alert('Có lỗi xảy ra trong quá trình thanh toán!'); window.location.href='index.php?act=cart';</script>";
        // }
    }
}