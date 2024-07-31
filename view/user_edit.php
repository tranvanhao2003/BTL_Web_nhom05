<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin</title>
    <link rel="stylesheet" href="../public/css/include.css">
    <link rel="stylesheet" href="../icons/themify-icons-font/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/edit.css">
    <style>
    .input_form label {
        color: #0c4ca3;
    }

    button {
        background-color: #0c4ca3;
        color: white;
    }

    button:hover {
        background-color: #0a3b82;
    }

    .mess {
        color: #0c4ca3;
    }

    .mess.error {
        color: red;
    }
    </style>
    <script src="https://kit.fontawesome.com/97f11440fd.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <?php
    require "../config.php";

    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];

        $select_sql = $conn->prepare("SELECT username, role FROM user WHERE id = ?");
        $select_sql->bind_param("i", $user_id);
        $select_sql->execute();
        $select_sql->bind_result($username, $role);
        $select_sql->fetch();
        $select_sql->close();
    } else {
        header("Location: userlist.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_username = $_POST['new_username'];
        $new_role = $_POST['new_role'];

        $update_sql = $conn->prepare("UPDATE user SET username = ?, role = ? WHERE id = ?");
        $update_sql->bind_param("ssi", $new_username, $new_role, $user_id);

        if ($update_sql->execute()) {
            $message = "Cập nhật người dùng thành công!";
            echo '<script>alert("Cập nhật người dùng thành công!"); window.location.href = "userlist.php";</script>';
        } else {
            $message = "Có lỗi xảy ra. Vui lòng thử lại.";
            echo '<script>alert("Có lỗi xảy ra. Vui lòng thử lại.");</script>';
        }

        $update_sql->close();
    }
    ?>
    <div class="container">
        <div class="submenu">
            <ul>
                <h3>Admin Menu</h3>
                <li><a href="./admin.php">Danh sách bài viết</a></li>
                <li><a href="./userlist.php">Danh sách người dùng</a></li>
                <li class="active">Cập nhật người dùng</li>
            </ul>
        </div>
        <div class="list">
            <?php if (isset($message)) : ?>
            <div class="box">
                <div class="mess <?= strpos($message, 'thành công') !== false ? '' : 'error' ?>">
                    <?= $message ?>
                </div>
                <a href="userlist.php">Quay về trang quản trị</a>
            </div>
            <?php else : ?>
            <h2>Cập nhật người dùng <?= htmlspecialchars($username) ?></h2>
            <form action="./user_edit.php?id=<?= $user_id ?>" method="POST" id="edit_form">
                <div class="input_form">
                    <label for="new_username">Tên đăng nhập mới</label>
                    <input type="text" name="new_username" class="input2" value="<?= htmlspecialchars($username) ?>">
                </div>
                <div class="input_form">
                    <label for="new_role">Vai trò mới</label>
                    <select name="new_role">
                        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>Thành viên</option>
                        <?php if ($role !== 'admin' && $role !== 'user') : ?>
                        <option value="<?= htmlspecialchars($role) ?>" selected><?= htmlspecialchars($role) ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <button type="submit">Cập nhật thông tin</button>
            </form>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>