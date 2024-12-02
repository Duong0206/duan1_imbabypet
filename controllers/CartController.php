<?php

    require_once './models/CartModel.php';
    require_once './models/ProductModel.php';
    require_once './commons/helper.php';

    class CartController
    {
        public $cartModel;
        public $productModel;

        function __construct()
        {
            $this->cartModel = new CartModel();
            $this->productModel = new ProductModel();
        }
    
        public function cart()
        {
            if(!isset($_SESSION['MaAdmin'])){
                echo "<script>alert('Vui lòng đăng nhập để truy cập giỏ hàng!'); window.location.href='index.php?act=showLogin';</script>";
                exit;
    
            }

            $MaKH = $_SESSION['MaAdmin'];
            $cart = $this->cartModel->getCartByCustomer($MaKH);

            if(!$cart){
                $cartId = $this->cartModel->createCart($MaKH);
            }else{
                $cartId = $cart['MaGioHang'];
            }

            $cartDetails = $this->cartModel->getCartDetails($cartId);
    
            require_once "./views/pages/Cart.php";
        }

        public function addToCart()
        {
            if (!isset($_SESSION['MaAdmin'])) {
                echo "<script>alert('Vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ hàng!'); window.location.href='index.php?act=showLogin';</script>";
                exit;
            }
        
            $MaKH = $_SESSION['MaAdmin'];
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
            $cart = $this->cartModel->getCartByCustomer($MaKH);
        
            if (!$cart) {
                $cartId = $this->cartModel->createCart($MaKH);
            } else {
                $cartId = $cart['MaGioHang'];
            }
        
            $this->cartModel->addProductToCart($cartId, $MaSP, $SoLuong, $DonGia);
        
            echo "<script>alert('Thêm sản phẩm vào giỏ hàng thành công!'); window.location.href='index.php?act=cart';</script>";
        }
        
    
        // Xóa sản phẩm khỏi giỏ hàng
        public function removeCart()
        {
            $productId = $_GET['id'] ?? null;
        
            if ($productId) {
                $cart = $this->cartModel->getCartByCustomer($_SESSION['MaAdmin']);
                $cartId = $cart['MaGioHang'];
                $this->cartModel->removeProductFromCart($cartId, $productId);
            }
        
            header('Location: index.php?act=cart');
            exit;
        }
    
    

        public function updateCart()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $input = json_decode(file_get_contents('php://input'), true);
                $productId = $input['id'] ?? null;
                $newQuantity = $input['quantity'] ?? 0;
        
                // Kiểm tra giỏ hàng của người dùng
                $cart = $this->cartModel->getCartByCustomer($_SESSION['MaAdmin']);
                if (!$cart) {
                    echo json_encode(['success' => false, 'message' => 'Giỏ hàng không tồn tại']);
                    exit;
                }
        
                $cartId = $cart['MaGioHang'];
        
                if ($productId && $newQuantity > 0) {
                    // Cập nhật số lượng sản phẩm trong giỏ hàng
                    $this->cartModel->updateProductQuantity($cartId, $productId, $newQuantity);
        
                    // Tính lại tổng tiền giỏ hàng
                    $cartTotal = $this->cartModel->calculateCartTotal($cartId);
        
                    echo json_encode([
                        'success' => true,
                        'cartTotal' => number_format($cartTotal, 0, ',', '.')
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ']);
                }
            }
        }
        

        


    }



