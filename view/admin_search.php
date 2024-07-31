<?php
require "../config.php";

$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Tìm kiếm người dùng
$select_user_sql = $conn->prepare("SELECT id, username, role FROM user WHERE username LIKE ?");
$search_query_like = "%$search_query%";
$select_user_sql->bind_param("s", $search_query_like);

$user_results = [];
if ($select_user_sql->execute()) {
    $result = $select_user_sql->get_result();
    while ($row = $result->fetch_assoc()) {
        $user_results[] = $row;
    }
    $select_user_sql->close();
} else {
    echo '<script>alert("Lỗi khi thực hiện truy vấn cho người dùng");</script>';
    die("Lỗi khi thực hiện lệnh SQL cho người dùng: " . $select_user_sql->error);
}

// Tìm kiếm bài viết
$select_post_sql = $conn->prepare("SELECT id, title, img, short_description FROM blog WHERE title LIKE ?");
$select_post_sql->bind_param("s", $search_query_like);

$post_results = [];
if ($select_post_sql->execute()) {
    $result = $select_post_sql->get_result();
    while ($row = $result->fetch_assoc()) {
        $post_results[] = $row;
    }
    $select_post_sql->close();
} else {
    echo '<script>alert("Lỗi khi thực hiện truy vấn cho bài viết");</script>';
    die("Lỗi khi thực hiện lệnh SQL cho bài viết: " . $select_post_sql->error);
}

if (empty($user_results) && empty($post_results)) {
    echo '<h2>Không có kết quả tìm kiếm phù hợp.</h2>';
} else {
    if (!empty($user_results)) {
        echo '
        <h2>Kết quả tìm kiếm người dùng:</h2>
        <table id="admin_form">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Vai trò</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($user_results as $user) {
            echo '
            <tr>
                <td>' . $user['id'] . '</td>
                <td>' . $user['username'] . '</td>
                <td>' . $user['role'] . '</td>
                <td><a href="./user_edit.php?id=' . $user['id'] . '">Sửa</a></td>
                <td class="delete_btn">
                    <form method="post" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa người dùng này không?\');">
                        <input type="hidden" name="id" value="' . $user['id'] . '">
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>';
        }
        echo '</tbody></table>';
    }

    if (!empty($post_results)) {
        echo '
        <h2>Kết quả tìm kiếm bài viết:</h2>
        <table id="admin_form">
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
        <tbody>';
        foreach ($post_results as $post) {
            echo '
            <tr>
                <td>' . $post['id'] . '</td>
                <td>' . $post['title'] . '</td>
                <td class="img"><img style="width: 80px;" src="' . $post['img'] . '"></td>
                <td>' . $post['short_description'] . '</td>
                <td><a href="./post_edit.php?id=' . $post['id'] . '">Sửa</a></td>
                <td class="delete_btn">
                    <form method="post" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa bài viết này không?\');">
                        <input type="hidden" name="id" value="' . $post['id'] . '">
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>';
        }
        echo '</tbody></table>';
    }
}

$conn->close();
?>