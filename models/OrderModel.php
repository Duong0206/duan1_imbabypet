<?php
require_once './commons/function.php';

class OrderModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function createOrder($MaKH, $TongTien)
    {
        try {
            $sql = "INSERT INTO DonDatHang (MaKH, NgayDat, TinhTrangDH, DaThanhToan, TongTien) 
                    VALUES (:MaKH, NOW(), 'pending', 0, :TongTien)";
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

    // Thêm chi tiết đơn hàng
    public function addOrderDetail($MaDH, $MaSP, $SoLuong, $DonGia)
    {
        try {
            $sql = "INSERT INTO CTDonHang (MaDH, MaSP, SoLuong, DonGia, ThanhTien) 
                    VALUES (:MaDH, :MaSP, :SoLuong, :DonGia, :ThanhTien)";
            $stmt = $this->conn->prepare($sql);

            $ThanhTien = $DonGia * $SoLuong; // Tính tổng tiền cho sản phẩm

            $stmt->bindParam(':MaDH', $MaDH, PDO::PARAM_INT);
            $stmt->bindParam(':MaSP', $MaSP, PDO::PARAM_INT);
            $stmt->bindParam(':SoLuong', $SoLuong, PDO::PARAM_INT);
            $stmt->bindParam(':DonGia', $DonGia, PDO::PARAM_INT);
            $stmt->bindParam(':ThanhTien', $ThanhTien, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi thêm chi tiết đơn hàng: " . $e->getMessage();
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

    // Phương thức thêm đơn hàng
    public function addOrder($orderData)
    {
        try {
            $sql = "INSERT INTO DonDatHang (MaKH, NgayDat, NgayGiao, TinhTrangDH, DaThanhToan, TongTien) 
                    VALUES (:MaKH, NOW(), :NgayGiao, 'pending', :DaThanhToan, :TongTien)";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaKH', $orderData['MaKH'], PDO::PARAM_INT);
            $stmt->bindParam(':NgayGiao', $orderData['NgayGiao'], PDO::PARAM_STR);
            $stmt->bindParam(':DaThanhToan', $orderData['DaThanhToan'], PDO::PARAM_INT);
            $stmt->bindParam(':TongTien', $orderData['TongTien'], PDO::PARAM_INT);
            
            $stmt->execute();

            return $this->conn->lastInsertId(); // Trả về ID của đơn hàng vừa tạo
        } catch (PDOException $e) {
            echo "Lỗi tạo đơn hàng: " . $e->getMessage();
            return false;
        }
    }

    // Lưu chi tiết đơn hàng
    public function addOrderDetails($MaDH, $MaSP, $SoLuong, $DonGia)
    {
        $sql = "INSERT INTO CTDonHang (MaDH, MaSP, SoLuong, DonGia, ThanhTien) VALUES (:MaDH, :MaSP, :SoLuong, :DonGia, :ThanhTien)";
        $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':MaDH', 'MaDH', PDO::PARAM_INT);
            $stmt->bindParam(':MaSP', 'MaSP', PDO::PARAM_INT);
            $stmt->bindParam(':SoLuong','SoLuong', PDO::PARAM_INT);
            $stmt->bindParam(':DonGia', 'DonGia', PDO::PARAM_INT);
            $stmt->bindParam(':ThanhTien', 'ThanhTien', PDO::PARAM_INT);
            $stmt->execute();
    }

    public function checkCustomerExists($MaKH)
    {
        try {
            $sql = "SELECT * FROM KhachHang WHERE MaKH = :MaKH";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaKH', $MaKH, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi kiểm tra khách hàng: " . $e->getMessage();
            return false;
        }
    }

    public function addCustomer($data)
    {
        try {
            $sql = "INSERT INTO KhachHang (MaKH, HoTen, DiaChi, DienThoai, Email) 
                    VALUES (:MaKH, :HoTen, :DiaChi, :DienThoai, :Email)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaKH', $data['MaKH'], PDO::PARAM_INT);
            $stmt->bindParam(':HoTen', $data['HoTen'], PDO::PARAM_STR);
            $stmt->bindParam(':DiaChi', $data['DiaChi'], PDO::PARAM_STR);
            $stmt->bindParam(':DienThoai', $data['DienThoai'], PDO::PARAM_STR);
            $stmt->bindParam(':Email', $data['Email'], PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi thêm khách hàng: " . $e->getMessage();
            return false;
        }
    }


    // Lấy danh sách đơn hàng theo mã khách hàng
    public function getOrdersByCustomerId($MaKH)
    {
        try {
            $sql = "SELECT * FROM DonDatHang WHERE MaKH = :MaKH ORDER BY NgayDat DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaKH', $MaKH, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi lấy danh sách đơn hàng: " . $e->getMessage();
            return false;
        }
    }

        // Phương thức lấy chi tiết đơn hàng bao gồm đơn hàng, chi tiết sản phẩm, và khách hàng
    public function viewOrderDetail($MaDH)
    {
        try {
            // Lấy thông tin đơn hàng
            $sql = "SELECT * FROM DonDatHang WHERE MaDH = :MaDH";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaDH', $MaDH, PDO::PARAM_INT);
            $stmt->execute();
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                return false; // Không tìm thấy đơn hàng
            }
            //lấy chi tiết sản phẩm
            $sql = "SELECT * FROM SanPham WHERE MaSP = :MaSP";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaSP', $order['MaSP'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // Lấy chi tiết đơn hàng (sản phẩm)
            $sql = "SELECT * FROM CTDonHang WHERE MaDH = :MaDH";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaDH', $MaDH, PDO::PARAM_INT);
            $stmt->execute();
            $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Lấy thông tin khách hàng
            $sql = "SELECT * FROM KhachHang WHERE MaKH = :MaKH";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':MaKH', $order['MaKH'], PDO::PARAM_INT);
            $stmt->execute();
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'order' => $order,
                'orderDetails' => $orderDetails,
                'customer' => $customer
            ];
        } catch (PDOException $e) {
            echo "Lỗi lấy chi tiết đơn hàng: " . $e->getMessage();
            return false;
        }
    }
}
