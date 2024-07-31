<?php
session_start();

require "../config.php";

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra quyền quản trị
$userRole = $_SESSION['user_role'];
if ($userRole !== "admin") {
    $_SESSION["role_error"] = "Bạn không có quyền quản trị";
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $user_id = $_POST['id'];

    // Chuẩn bị câu lệnh xóa người dùng
    $delete_sql = $conn->prepare("DELETE FROM user WHERE id = ?");
    $delete_sql->bind_param("i", $user_id);

    // Thực thi câu lệnh xóa
    if ($delete_sql->execute()) {
        echo '<script>alert("Xóa người dùng thành công."); window.location.href = "userlist.php";</script>';
    } else {
        echo '<script>alert("Xóa người dùng thất bại. Vui lòng thử lại.");</script>';
        error_log("Xóa người dùng thất bại: " . $delete_sql->error);
    }

    $delete_sql->close();
}

// Truy vấn tất cả người dùng
$sql = "SELECT id, username, role FROM user";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        $row['counter_id'] = $counter++;
        $users[] = $row;
    }
}

$result->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng</title>
    <link rel="stylesheet" href="../public/css/include.css">
    <link rel="stylesheet" href="../public/css/admin_list.css">
    <link rel="stylesheet" href="../icons/themify-icons-font/themify-icons/themify-icons.css">
    <script src="https://kit.fontawesome.com/97f11440fd.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <div class="container">
        <div class="submenu">
            <ul>
                <h3>Admin Menu</h3>
                <li><a href="./admin.php">Danh sách bài viết</a></li>
                <li><a href="./userlist.php" class="active">Danh sách người dùng</a></li>
            </ul>
        </div>

        <div class="list">
            <h2 style="margin-top: 0;">Danh sách người dùng</h2>
            <a href="./register.php" class="add_btn">Thêm người dùng</a>
            <table id="admin_form" style="margin-bottom: 270px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Vai trò</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo $user['counter_id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a href="./user_edit.php?id=<?= $user['id'] ?>">Sửa</a>
                        </td>
                        <td class="delete_btn">
                            <form method="post"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>