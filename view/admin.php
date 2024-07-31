<?php
session_start();
require "../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userRole = $_SESSION['user_role'];
if ($userRole !== "admin") {
    $_SESSION["role_error"] = "Bạn không có quyền quản trị";
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $post_id = $_POST['id'];

    $delete_sql = $conn->prepare("DELETE FROM blog WHERE id = ?");
    $delete_sql->bind_param("i", $post_id);

    if ($delete_sql->execute()) {
        echo '<script>alert("Xóa bài viết thành công."); window.location.href = "admin.php";</script>';
    } else {
        echo '<script>alert("Xóa bài viết thất bại. Vui lòng thử lại.");</script>';
        error_log("Xóa bài viết thất bại: " . $delete_sql->error);
    }

    $delete_sql->close();
}

$sql = 'SELECT * FROM blog';
$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        $row['counter_id'] = $counter++;
        $posts[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
                <li><a href="./admin.php" class="active">Danh sách bài viết</a></li>
                <li><a href="./userlist.php">Danh sách người dùng</a></li>
            </ul>
        </div>

        <div class="list">
            <a href="post_add.php" class="add_btn">Thêm bài viết</a>

            <form action="#" method="GET" id="search_form">
                <input type="text" name="search_query" id="search_query" placeholder="Nhập ID hoặc tên bài viết">
                <button type="button" onclick="performSearch()" class="search_btn">Tìm kiếm</button>
            </form>

            <div id="search_results"></div>

            <table id="admin_form" class="admin">
                <caption class="h2">Danh sách bài viết</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề bài viết</th>
                        <th>Ảnh</th>
                        <th>Mô tả ngắn</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post) { ?>
                    <tr>
                        <td><?php echo $post['counter_id']; ?></td>
                        <td><?php echo $post['title']; ?></td>
                        <td class="img"><?php echo '<img style="width: 80px;" src="'. $post['img'] .'">'; ?></td>
                        <td><?php echo $post['short_description']; ?></td>
                        <td class="edit_btn">
                            <a href="post_edit.php?id=<?= $post['id'] ?>">Sửa</a>
                        </td>
                        <td class="delete_btn">
                            <form method="post"
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');">
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function performSearch() {
        var searchQuery = document.getElementById('search_query').value;
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('search_results').innerHTML = this.responseText;

                var adminElement = document.querySelector('.admin');
                var searchElement = document.getElementById('search_results')

                adminElement && (this.responseText.length > 0 ? adminElement.classList.add('hidden') : adminElement
                    .classList.remove('hidden'));
                searchElement && (this.responseText.length > 0 ? searchElement.classList.add('search') :
                    searchElement
                    .classList.remove('search'));
            }
        };

        xhttp.open('GET', './admin_search.php?search_query=' + searchQuery, true);
        xhttp.send();
    }
    </script>
</body>

</html>