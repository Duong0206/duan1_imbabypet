<?php

// Kết nối CSDL qua PDO
function connectDB() {
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
        return $conn;
    } catch (PDOException $e) {
        echo ("Connection failed: " . $e->getMessage());
    }
}

function isLoggedIn() {
    if (isset($_SESSION['MaAdmin']) && is_numeric($_SESSION['MaAdmin'])) {
        // Kết nối DB
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM admin WHERE MaAdmin = :MaAdmin");
        $stmt->bindParam(':MaAdmin', $_SESSION['MaAdmin'], PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0; // Nếu tồn tại, trả về true
    }
    return false; // Không tồn tại session hoặc không hợp lệ
}
