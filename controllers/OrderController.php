<?php

require_once './models/OrderModel.php';
require_once './models/ProductModel.php';
require_once './models/CartModel.php';
require_once './commons/helper.php';

class OrderController
{
    public $orderModel;
    public $productModel;
    public $cartModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
        $this->cartModel = new CartModel();
    }

    // Hiển thị form đặt hàng
    public function showFormOrder()
    {
        // Kiểm tra nếu có sản phẩm được chọn
        if (isset($_POST['selected_products'])) {
            $selectedProductIds = $_POST['selected_products'];
    
            // Kiểm tra và lấy số lượng sản phẩm từ form, nếu không có thì khởi tạo mảng rỗng
            $productQuantities = isset($_POST['product_quantities']) ? $_POST['product_quantities'] : [];


            if (empty($selectedProductIds)) {
                echo "Không có sản phẩm nào được chọn để thanh toán!";
                return;
            }
    
            // Lọc số lượng chỉ cho sản phẩm được chọn
            $filteredQuantities = array_filter(
                $productQuantities,
                fn($key) => in_array($key, $selectedProductIds),
                ARRAY_FILTER_USE_KEY
            );
    
            // Lấy thông tin chi tiết của sản phẩm đã chọn
            $productDetails = $this->productModel->getProductsByIds($selectedProductIds);
    
            // Tính tổng tiền và bổ sung thông tin số lượng vào sản phẩm
            $totalAmount = 0;
            foreach ($productDetails as $key => $item) {
                $quantity = $filteredQuantities[$item['MaSP']] ?? 0;
                $productDetails[$key]['SoLuong'] = $quantity;
                $productDetails[$key]['total'] = $item['DonGiaBan'] * $quantity;
                $totalAmount += $productDetails[$key]['total'];
            }
    
            // Truyền dữ liệu tới view
            require_once "./views/pages/FormOrder.php";
        } else {
            // Nếu không có sản phẩm nào được chọn
            header('Location: index.php?act=cart');
            exit();
        }
    }
    

    // Xử lý thanh toán
    public function processPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy thông tin khách hàng từ form
            $hoTen = $_POST['HoTen'];
            $dienThoai = $_POST['DienThoai'];
            $email = $_POST['Email'];
            $diaChi = $_POST['DiaChi'];
            $phuongThucThanhToan = $_POST['PhuongThucThanhToan'];
    
            // Kiểm tra dữ liệu đầu vào
            if (empty($hoTen) || empty($dienThoai) || empty($email) || empty($diaChi) || empty($phuongThucThanhToan)) {
                echo "Vui lòng nhập đủ thông tin!";
                return;
            }
    
            // Lấy ID khách hàng từ session
            $maKH = $_SESSION['MaAdmin'];
    
            // Thêm thông tin khách hàng nếu cần
            $customerData = [
                'HoTen' => $hoTen,
                'DiaChi' => $diaChi,
                'DienThoai' => $dienThoai,
                'Email' => $email,
            ];
            $this->orderModel->addCustomer($customerData);
    
            // Lấy CartID từ cơ sở dữ liệu
            $cartId = $this->cartModel->getCartByCustomer($maKH);
    
            if (!$cartId) {
                echo "Giỏ hàng không tồn tại!";
                return;
            }
    
            // Lấy thông tin sản phẩm từ form
            $selectedProductIds = $_POST['selected_products'] ?? [];
            $productQuantities = $_POST['product_quantities'] ?? [];

    
            // Kiểm tra sản phẩm được chọn
            if (empty($selectedProductIds)) {
                echo "Không có sản phẩm nào được chọn để thanh toán!";
                return;
            }
    
            // Lấy thông tin sản phẩm từ DB
            $productDetails = $this->productModel->getProductsByIds($selectedProductIds);
    
            // Tính tổng tiền
            $totalAmount = 0;
            foreach ($productDetails as $item) {
                $productId = $item['MaSP'];
                $quantity = $productQuantities[$productId] ?? 0;
                $totalAmount += $item['DonGiaBan'] * $quantity;
            }
    
            // Nếu tổng tiền bằng 0, thông báo lỗi
            if ($totalAmount <= 0) {
                echo "Tổng tiền không hợp lệ!";
                return;
            }
    
            // Tạo đơn hàng
            $orderData = [
                'MaKH' => $maKH,
                'NgayGiao' => date('Y-m-d', strtotime('+3 days')),
                'DaThanhToan' => $phuongThucThanhToan === 'cod' ? 0 : 1,
                'TongTien' => $totalAmount,
            ];
            $orderId = $this->orderModel->addOrder($orderData);
    
            if ($orderId) {
                // Thêm chi tiết đơn hàng
                foreach ($productDetails as $item) {
                    $productId = $item['MaSP'];
                    $quantity = $productQuantities[$productId] ?? 0;
                    if ($quantity > 0) {
                        $this->orderModel->addOrderDetail($orderId, $productId, $quantity, $item['DonGiaBan']);
    
                        // Xóa sản phẩm khỏi giỏ hàng
                        $this->cartModel->removeProductFromCart($cartId, $productId);
                    }
                }
    
                // Hiển thị trang thành công
                require_once "./views/pages/SuccessOrder.php";
                exit();
            } else {
                echo "Lỗi khi tạo đơn hàng!";
            }
        }
    }

    // Phương thức hiển thị danh sách đơn hàng
    public function listOrders()
    {
        // Lấy ID khách hàng từ session
        $maKH = $_SESSION['MaAdmin'] ?? null;

        if (!$maKH) {
            echo "Bạn cần đăng nhập để xem danh sách đơn hàng.";
            header('Location: index.php?act=showLogin');
            exit();
        }

        // Lấy danh sách đơn hàng của khách hàng
        $orders = $this->orderModel->getOrdersByCustomerId($maKH);

        // Hiển thị view danh sách đơn hàng
        require_once './views/pages/OrderList.php';
    }


    
    public function orderDetail()
    {
        // Gọi phương thức từ model
        $MaDH = $_GET['MaDH'];
        $orderDetail = $this->orderModel->viewOrderDetail($MaDH);


        if (!$orderDetail) {
            // Xử lý khi không tìm thấy đơn hàng
            echo "Không tìm thấy đơn hàng.";
            return;
        }

        // Truyền dữ liệu cho view
        $order = $orderDetail['order'];
        $orderDetails = $orderDetail['orderDetails'];
        $customer = $orderDetail['customer'];
        $product = $orderDetail['product'];

        require './views/pages/orderDetail.php';
    }
    
    
    
}
