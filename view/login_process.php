<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../config.php";

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id, username, role FROM user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["user_role"] = $row["role"];

        if ($row["role"] === "admin") {
            header("Location: admin.php");
            exit();
        } else {
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION["login_error"] = "Tên người dùng hoặc mật khẩu không đúng.";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>