<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật bài viết</title>
    <link rel="stylesheet" href="../public/css/include.css">
    <link rel="stylesheet" href="../icons/themify-icons-font/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/blog_edit.css">
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
        $post_id = $_GET['id'];

        $select_sql = $conn->prepare("SELECT title, img, category, short_description, content, author FROM blog WHERE id = ?");
        $select_sql->bind_param("i", $post_id);
        $select_sql->execute();
        $select_sql->bind_result($title, $img, $category, $short_description, $content, $author);
        $select_sql->fetch();
        $select_sql->close();
    } else {
        header("Location: admin.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_title = $_POST['new_title'];
        $new_img = $_POST['new_img'];
        $new_category = $_POST['new_category'];
        $new_short_description = $_POST['new_short_description'];
        $new_content = $_POST['new_content'];
        $new_author = $_POST['new_author']; 

        $update_sql = $conn->prepare("UPDATE blog SET title = ?, img = ?, category = ?, short_description = ?, content = ?, author = ? WHERE id = ?");
        $update_sql->bind_param("ssssssi", $new_title, $new_img, $new_category, $new_short_description, $new_content, $new_author, $post_id);

        if ($update_sql->execute()) {
            $message = "Cập nhật bài viết thành công!";
            echo '<script>alert("Cập nhật bài viết thành công!"); window.location.href = "admin.php";</script>';
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
                <li class="active">Cập nhật bài viết</li>
            </ul>
        </div>
        <div class="list">
            <?php if (isset($message)) : ?>
            <div class="box">
                <div class="mess <?= strpos($message, 'thành công') !== false ? '' : 'error' ?>">
                    <?= $message ?>
                </div>
                <a href="admin.php">Quay về trang quản trị</a>
            </div>
            <?php else : ?>
            <h2>Cập nhật bài viết <?= htmlspecialchars($title) ?></h2>
            <form action="./post_edit.php?id=<?= $post_id ?>" method="POST" id="edit_form">
                <div class="input_form">
                    <label for="new_title">Tiêu đề mới</label>
                    <input type="text" name="new_title" value="<?= htmlspecialchars($title) ?>">
                </div>
                <div class="input_form">
                    <label for="new_img">Ảnh mới</label>
                    <input type="text" name="new_img" value="<?= htmlspecialchars($img) ?>">
                </div>
                <div class="input_form">
                    <label for="new_category">Danh mục mới</label>
                    <input type="text" name="new_category" value="<?= htmlspecialchars($category) ?>">
                </div>
                <div class="input_form">
                    <label for="new_short_description">Mô tả ngắn mới</label>
                    <textarea rows="10"
                        name="new_short_description"><?= htmlspecialchars($short_description) ?></textarea>
                </div>
                <div class="input_form">
                    <label for="new_content">Nội dung</label>
                    <textarea rows="10" name="new_content"><?= htmlspecialchars($content) ?></textarea>
                </div>
                <div class="input_form">
                    <label for="new_author">Tác giả</label>
                    <input type="text" name="new_author" value="<?= htmlspecialchars($author) ?>">
                </div>
                <button type="submit">Cập nhật thông tin</button>
            </form>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>