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
        require_once "./views/pages/Cart.php";
    }




}