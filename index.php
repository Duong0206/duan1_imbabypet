<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once './commons/env.php';
require_once './commons/function.php';
require_once './controllers/HomeController.php';
require_once './controllers/AuthController.php';

$act = $_GET['act'] ?? '/';
$authController = new AuthController();
$homeController = new HomeController();

match ($act) {
    // Trang chủ
    '/'                 => $homeController->index(),

    // Trang chi tiết sản phẩm
    'productDetail'     => $homeController->productDetail($_GET['MaSP']),

    // Trang giỏ hàng (bắt buộc đăng nhập)
    'cart'              => $homeController->cart(),

    // Hiển thị trang đăng nhập
    'showLogin'         => $authController->showLogin(),

    // Xử lý đăng nhập
    'login'             => ($_SERVER['REQUEST_METHOD'] === 'POST') 
                            ? $authController->login() 
                            : $authController->showLogin(),

    // Đăng xuất
    'logout'            => $authController->logout(),

    'addToCart'         => $homeController->addToCart(),

    'remove-cart'       => $homeController->removeCart(),

    'showCheckout'          => $homeController->showCheckout(),

    


    // Mặc định
    default             => function () {
        echo "404 - Không tìm thấy trang.";
    }
};








// /admin
//     /controller
//     /model
//     /views
//     /index
// /assets(đây là forder của template tôi muốn dùng)
//     /assets
//     /css
//     /images
//     /js
//     /index.html
// /commons
// /controllers
// /models
// /uploads
// /views(chưa có gì)
//     /includes
//     /layouts
//     /pages
//     /templates
// /index
