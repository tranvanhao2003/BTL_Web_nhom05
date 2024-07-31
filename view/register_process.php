<?php
session_start();
require "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION["register_error"] = "Mật khẩu và xác nhận mật khẩu không khớp.";
        header("Location: register.php");
        exit();
    }

    $check_sql = $conn->prepare("SELECT id FROM user WHERE username = ?");
    $check_sql->bind_param("s", $username);
    $check_sql->execute();
    $check_sql->store_result();

    if ($check_sql->num_rows > 0) {
        $_SESSION["register_error"] = "Tên đăng nhập đã tồn tại.";
        $check_sql->close();
        header("Location: register.php");
        exit();
    }

    $check_sql->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_sql = $conn->prepare("INSERT INTO user (username, password, role) VALUES (?, ?,  'user')");
    $insert_sql->bind_param("ss", $username, $hashed_password);

    if ($insert_sql->execute()) {
        $_SESSION["register_success"] = "Đăng ký thành công. Bạn có thể đăng nhập.";
        echo '<script>alert("Đăng ký thành công. Bạn có thể đăng nhập."); window.location.href = "login.php";</script>';
        exit();
    } else {
        $_SESSION["register_error"] = "Có lỗi xảy ra. Vui lòng thử lại.";
        header("Location: register.php");
        exit();
    }

    $insert_sql->close();
}
?>