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

    public function getProductsByIds($productIds)
    {
        // Chuyển mảng IDs thành chuỗi để sử dụng trong câu truy vấn
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));

        $sql = "SELECT * FROM SanPham WHERE MaSP IN ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($productIds); // Truyền mảng IDs vào câu truy vấn
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function searchProducts($keyword){
        
        $sql = "SELECT * FROM  SanPham WHERE TenSP LIKE :keyword OR description LIKE :keyword";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);








    }
    
}