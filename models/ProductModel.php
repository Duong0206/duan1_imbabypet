<?php 

require_once './commons/function.php';

class ProductModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllProducts(){
        $query = "SELECT * FROM SanPham";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchALl();
    }

    public function getProductByID($MaSP){
        try{
            $sql = "SELECT * FROM SanPham WHERE MaSP = $MaSP";
            $result = $this->conn->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "lỗi truy vấn connect" .$e->getMessage();
            return [];
        }
    }
    
}