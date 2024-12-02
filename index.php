<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once './commons/env.php';
require_once './commons/function.php';
require_once './controllers/HomeController.php';
require_once './controllers/AuthController.php';
require_once './controllers/OrderController.php';
require_once './controllers/CartController.php';

$act = $_GET['act'] ?? '/';
$authController = new AuthController();
$homeController = new HomeController();
$orderController = new OrderController();
$cartController = new CartController();

match ($act) {
    // Trang chủ
    '/'                 => $homeController->index(),

    // Trang chi tiết sản phẩm
    'productDetail'     => $homeController->productDetail($_GET['MaSP']),

    // Trang giỏ hàng (bắt buộc đăng nhập)
    'cart'              => $cartController->cart(),

    // Hiển thị trang đăng nhập
    'showLogin'         => $authController->showLogin(),

    // Xử lý đăng nhập
    'login'             => ($_SERVER['REQUEST_METHOD'] === 'POST') 
                            ? $authController->login() 
                            : $authController->showLogin(),

    // Đăng xuất
    'logout'            => $authController->logout(),

    'addToCart'         => $cartController->addToCart(),

    'remove-cart'       => $cartController->removeCart(),


    //đặt hàg
    'showFormOrder'          => $orderController->showFormOrder(),

    'processPayment'        => $orderController->processPayment(),

    'listOrders'    => $orderController->listOrders(),

    'viewOrderDetail' => $orderController->orderDetail($_GET['MaDH']),




    //tìm kiếm
    'search'            => $homeController->search(),
    


    // Mặc định
    default             => function () {
        echo "404 - Không tìm thấy trang.";
    }
};
