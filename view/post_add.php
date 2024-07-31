<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài viết mới</title>
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $img = isset($_POST['img']) ? $_POST['img'] : ''; 
        $category = $_POST['category'];
        $short_description = $_POST['short_description'];
        $content = $_POST['content'];
        $author = $_POST['author'];

        $insert_sql = $conn->prepare("INSERT INTO blog (title, img, category, short_description, content, author) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($insert_sql === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        
        $insert_sql->bind_param("ssssss", $title, $img, $category, $short_description, $content, $author);

        if ($insert_sql->execute()) {
            $message = "Thêm bài viết thành công!";
            echo '<script>alert("Thêm bài viết thành công!"); window.location.href = "admin.php";</script>';
        } else {
            $message = "Có lỗi xảy ra. Vui lòng thử lại.";
            echo '<script>alert("Có lỗi xảy ra. Vui lòng thử lại.");</script>';
        }

        $insert_sql->close();
    }
    ?>
    <div class="container">
        <div class="submenu">
            <ul>
                <h3>Admin Menu</h3>
                <li><a href="./admin.php">Danh sách bài viết</a></li>
                <li><a href="./userlist.php">Danh sách người dùng</a></li>
                <li class="active">Thêm bài viết mới</li>
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
            <h2>Thêm bài viết mới</h2>
            <form action="./post_add.php" method="POST" id="edit_form">
                <div class="input_form">
                    <label for="title">Tiêu đề</label>
                    <input type="text" name="title" class="input2" required>
                </div>
                <div class="input_form">
                    <label for="img">Đường dẫn ảnh</label>
                    <input type="text" name="img" class="input2" value="../img/news3.png">
                </div>
                <div class="input_form">
                    <label for="category">Danh mục</label>
                    <select name="category" class="input2" required>
                        <option value="news">News</option>
                        <option value="information">Information</option>
                        <option value="event">Event</option>
                    </select>
                </div>
                <div class="input_form">
                    <label for="short_description">Mô tả ngắn</label>
                    <textarea rows="5" name="short_description" class="input2" required></textarea>
                </div>
                <div class="input_form">
                    <label for="content">Nội dung</label>
                    <textarea rows="10" name="content" class="input2" required></textarea>
                </div>
                <div class="input_form">
                    <label for="author">Tác giả</label>
                    <input type="text" name="author" class="input2" required>
                </div>
                <button type="submit">Thêm bài viết</button>
            </form>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>