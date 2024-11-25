<?php

require_once './models/UserModel.php';


class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // // Hiển thị form đăng ký
    // public function showRegister()
    // {
    //     require_once './views/pages/auth/register.php';
    // }

    // // Xử lý đăng ký
    // public function register()
    // {
    //     $HoTen = $_POST['HoTen'] ?? null;
    //     $Email = $_POST['Email'] ?? null;
    //     $MatKhau = $_POST['MatKhau'] ?? null;

    //     if (!$HoTen || !$Email || !$MatKhau) {
    //         echo "Vui lòng nhập đầy đủ thông tin.";
    //         return;
    //     }

    //     $existingUser = $this->userModel->getUserByEmail($Email);
    //     if ($existingUser) {
    //         echo "Email đã tồn tại!";
    //         return;
    //     }

    //     $hashedPassword = md5($MatKhau); // Nên dùng password_hash() thay thế md5
    //     $this->userModel->createUser($HoTen, $Email, $hashedPassword);

    //     echo "Đăng ký thành công!";
    //     header("Location: index.php?act=login");
    // }

    // Hiển thị form đăng nhập
    public function showLogin()
    {
        if (isset($_SESSION['MaAdmin'])) {
            // Nếu đã đăng nhập, điều hướng về giỏ hàng
            echo "<script>alert('Bạnd dã đăng nhập rồi'); window.location.href='index.php?act=/';</script>";
            exit;
        }
        require_once './views/pages/auth/login.php';
    }

    // Xử lý đăng nhập
    public function login()
    {
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($email && $password) {
            // Kiểm tra đăng nhập (giả định bảng `admin` có chứa email và mật khẩu)
            require_once './models/UserModel.php';
            $userModel = new UserModel();
            $user = $userModel->checkLogin($email, $password);

            if ($user) {
                // Lưu thông tin đăng nhập vào session
                $_SESSION['MaAdmin'] = $user['MaAdmin'];
                $_SESSION['HoTen'] = $user['HoTen'];

                // Điều hướng về giỏ hàng
                header('Location: index.php?act=/');
                exit;
            } else {
                // Sai email hoặc mật khẩu
                echo "<script>alert('Sai email hoặc mật khẩu!'); window.location.href='index.php?act=showLogin';</script>";
                exit;
            }
        }

        // Trường hợp thiếu thông tin
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin!'); window.location.href='index.php?act=showLogin';</script>";
        exit;
    }

    // Xử lý đăng xuất
    public function logout()
    {
        session_destroy();
        header('Location: index.php?act=login');
        exit;
    }
}
