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

    public function createOrder($MaKH, $TongTien)
    {
        try {
            $sql = "INSERT INTO DonDatHang (MaKH, NgayDat, TinhTrangDH, DaThanhToan, TongTien) 
                    VALUES (:MaKH, NOW(), 'Đang xử lý', 0, :TongTien)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaKH', $MaKH, PDO::PARAM_INT);
            $stmt->bindParam(':TongTien', $TongTien, PDO::PARAM_INT);
            $stmt->execute();
            return $this->conn->lastInsertId(); // Lấy ID đơn hàng vừa tạo
        } catch (PDOException $e) {
            echo "Lỗi tạo đơn hàng: " . $e->getMessage();
            return false;
        }
    }


    // Thêm chi tiết giỏ hàng
    public function addOrderDetail($MaDH, $MaSP, $SoLuong, $DonGia)
    {
        try {
            $sql = "INSERT INTO ChiTietGioHang (MaGioHang, MaSP, SoLuong, DonGia) 
                    VALUES (:MaDH, :MaSP, :SoLuong, :DonGia)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaDH', $MaDH, PDO::PARAM_INT);
            $stmt->bindParam(':MaSP', $MaSP, PDO::PARAM_INT);
            $stmt->bindParam(':SoLuong', $SoLuong, PDO::PARAM_INT);
            $stmt->bindParam(':DonGia', $DonGia, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi thêm chi tiết giỏ hàng: " . $e->getMessage();
        }
    }

    // Cập nhật tổng tiền đơn hàng
    public function updateOrderTotal($MaDH, $TongTien)
    {
        try {
            $sql = "UPDATE DonDatHang SET TongTien = :TongTien WHERE MaDH = :MaDH";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':TongTien', $TongTien, PDO::PARAM_INT);
            $stmt->bindParam(':MaDH', $MaDH, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi cập nhật tổng tiền: " . $e->getMessage();
        }
    }



    
    
}