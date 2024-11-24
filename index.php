<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';

// Require toàn bộ file Models

// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/'                 => (new HomeController())->index(),
    'productDetail'    => (new HomeController())->productDetail($_GET['MaSP']),
    'cart'              => (new HomeController())->cart(),
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
