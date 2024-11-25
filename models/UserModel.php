<?php

require_once './commons/function.php';

class UserModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // // Lấy người dùng theo email
    // public function getUserByEmail($email)
    // {
    //     $query = "SELECT * FROM admin WHERE Email = ?";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute([$email]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    // // Tạo người dùng mới
    // public function createUser($HoTen, $Email, $MatKhau, $MaQuyen = 2)
    // {
    //     $query = "INSERT INTO admin (HoTen, Email, MatKhau, MaQuyen) VALUES (?, ?, ?, ?)";
    //     $stmt = $this->conn->prepare($query);
    //     return $stmt->execute([$HoTen, $Email, $MatKhau, $MaQuyen]);
    // }

    public function checkLogin($email, $password)
    {
        $query = "SELECT * FROM admin WHERE Email = :email AND MatKhau = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // Mật khẩu chưa mã hóa
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin người dùng nếu tồn tại
    }
}
