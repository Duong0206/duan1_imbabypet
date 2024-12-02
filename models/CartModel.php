<?php

    require_once './commons/function.php';

    class CartModel
    {
        private $conn;

        public function __construct()
        {
            $this->conn = connectDB();
        }

        public function createCart($MaKH){
            try{
                $sql = "INSERT INTO GioHang (MaKH, NgayTao) VALUES (:MaKH, NOW())";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':MaKH', $MaKH, PDO::PARAM_INT);
                $stmt->execute();
                return $this->conn->lastInsertId(); // Lấy ID giỏ hàng vừa tạo

            }catch(PDOException $e){
                echo "Lỗi không thể tạo giỏ hàng".$e->getMessage();
                return false;
            }
        }

        public function getCartByCustomer($MaKH)
        {
            $sql = "SELECT * FROM GioHang WHERE MaKH = :MaKH LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaKH', $MaKH, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getCartDetails($MaGioHang)
        {
            $sql = "
                SELECT 
                    ctg.MaSP, 
                    ctg.SoLuong, 
                    ctg.DonGia, 
                    sp.TenSP, 
                    sp.HinhAnh
                FROM ChiTietGioHang ctg
                JOIN SanPham sp ON ctg.MaSP = sp.MaSP
                WHERE ctg.MaGioHang = :MaGioHang
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaGioHang', $MaGioHang, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function addProductToCart($MaGioHang, $MaSP, $SoLuong, $DonGia)
        {
            try {
                $sql = "INSERT INTO ChiTietGioHang (MaGioHang, MaSP, SoLuong, DonGia) 
                        VALUES (:MaGioHang, :MaSP, :SoLuong, :DonGia)
                        ON DUPLICATE KEY UPDATE SoLuong = SoLuong + :SoLuong";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':MaGioHang', $MaGioHang, PDO::PARAM_INT);
                $stmt->bindParam(':MaSP', $MaSP, PDO::PARAM_INT);
                $stmt->bindParam(':SoLuong', $SoLuong, PDO::PARAM_INT);
                $stmt->bindParam(':DonGia', $DonGia, PDO::PARAM_INT);
                $stmt->execute();                
            }catch(PDOException $e){
                echo "Lỗi thêm sản phẩm vào giỏ hàng: " . $e->getMessage();
            }
        }

        public function removeProductFromCart($MaGioHang, $MaSP)
        {
            // Kiểm tra nếu MaGioHang và MaSP không rỗng
            if (empty($MaGioHang) || empty($MaSP)) {
                return;
            }

            // Xóa sản phẩm cụ thể khỏi giỏ hàng
            $sql = "DELETE FROM ChiTietGioHang WHERE MaGioHang = :MaGioHang AND MaSP = :MaSP";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaGioHang', $MaGioHang, PDO::PARAM_INT);
            $stmt->bindParam(':MaSP', $MaSP, PDO::PARAM_INT);
            $stmt->execute();
        
        }


    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateProductQuantity($cartId, $productId, $newQuantity)
    {
        $stmt = $this->conn->prepare("UPDATE ChiTietGioHang SET SoLuong = :quantity WHERE MaGioHang = :cartId AND MaSP = :productId");
        $stmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
        $stmt->bindParam(':cartId', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Tính lại tổng tiền giỏ hàng
    public function calculateCartTotal($cartId)
    {
        $stmt = $this->conn->prepare("
            SELECT SUM(ChiTietGioHang.SoLuong * Product.DonGiaBan) AS total
            FROM ChiTietGioHang
            JOIN Product ON ChiTietGioHang.MaSP = Product.MaSP
            WHERE ChiTietGioHang.MaGioHang = :cartId
        ");
        $stmt->bindParam(':cartId', $cartId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }




    }